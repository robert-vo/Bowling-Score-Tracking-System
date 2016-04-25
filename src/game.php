<?php

/*

Bowling Score Calculator
Written by: Kyle Keith (kkeith29@cox.net)
Date: 02-22-2014

Run script from command line

*/

namespace bowling;
use mysqli;
define('NL','<br>');

error_reporting(-1);
ini_set('display_errors','On');

class game {

    const frame_count = 10;
    const total_pins  = 10;

    private $rolls     = array();
    private $roll_idx  = 1;
    private $frames    = array();
    private $frame_idx = 1;

    public function __construct()
    {
        
    }

    public function roll( $pin_count ) {
        echo '<br>number of pins = '. $pin_count;
        if ( !is_int( $pin_count ) ) {
            throw new \InvalidArgumentException('roll() function requires an integer as an argument');
        }
        if ( $pin_count < 0 || $pin_count > self::total_pins ) {
            throw new \RangeException('roll() function requires an integer between 0 and 10');
        }
        $this->rolls[$this->roll_idx] = $pin_count;
        if ( !isset( $this->frames[$this->frame_idx] ) ) {
            $this->frames[$this->frame_idx] = array();
        }
        $ball = ( count( $this->frames[$this->frame_idx] ) + 1 );
        $this->frames[$this->frame_idx][$ball] = $this->roll_idx;
        if ( $this->frame_idx !== self::frame_count && ( $ball === 2 || $pin_count === self::total_pins ) ) {
            $this->frame_idx++;
        }
        $this->roll_idx++;
    }

    public function frame( $roll_1,$roll_2=false,$roll_3=false ) {
        $this->roll( $roll_1 );
        if ( $roll_1 === self::total_pins ) {
            return;
        }
        if ( $roll_2 === false ) {
            throw new \InvalidArgumentException( 'frame() function requires second parameter if first does not equal ' . self::total_pins );
        }
        $frame_idx = $this->frame_idx;
        $this->roll( $roll_2 );
        if ( $frame_idx !== self::frame_count || ( $roll_1 + $roll_2 ) !== self::total_pins ) {
            return;
        }
        if ( $roll_3 === false ) {
            throw new \InvalidArgumentException( 'frame() function requires third parameter if first two equal ' . self::total_pins );
        }
        $this->roll( $roll_3 );
    }

    private function frame_score( $frame_idx ) {
        $frame = $this->frames[$frame_idx];
        $ball_count = count( $frame );
        $pin_count = 0;
        foreach( $frame as $ball => $roll_idx ) {
            $pin_count += $this->rolls[$roll_idx];
        }
        $bonus_rolls = ( $pin_count === self::total_pins ? ( $ball_count === 2 ? 1 : 2 ) : 0 );
        if ( $bonus_rolls > 0 ) {
            for ( $i=1;$i <= $bonus_rolls;$i++ ) {
                $next_roll_idx = ( $roll_idx + $i );
                if ( !isset( $this->rolls[$next_roll_idx] ) ) {
                    break;
                }
                $pin_count += $this->rolls[$next_roll_idx];
            }
        }
        return $pin_count;
    }

    public function score() {
        return array_sum( array_map( array( $this,'frame_score' ),array_keys( $this->frames ) ) );
    }

    public function score_by_frame() {
        $frames = array();
        $score = 0;
        foreach( array_keys( $this->frames ) as $frame_idx ) {
            $score += $this->frame_score( $frame_idx );
            $frames[$frame_idx] = $score;
        }
        return $frames;
    }


    public function stats() {
        echo 'Total Score: ' . $this->score() . NL;
        echo 'Rolls: ' . count( $this->rolls ) . NL;
        echo 'Frames: ' . count( $this->frames ) . NL;
        echo 'Frame Breakdown:' . NL;
        $frames = $this->score_by_frame();
        foreach( $frames as $frame_idx => $score ) {
            echo "\tFrame {$frame_idx}: {$score}" . NL;
        }
    }

    public function run() {
        echo '<br><br><br><br>';

        $game = new game;

        foreach (range(1, 10) as $item) {

            $sql = "SELECT group_concat(roll_one_id) as '1',
      group_concat(Roll_Two_ID) as '2',
      group_concat(Roll_Three_ID) as '3',
      Frame_Number
    FROM frame where Game_ID = 1 and Player_ID = 1 and Frame_Number = $item;";

            $conn = connectToDatabase();
            $result = $conn->query($sql);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if($row['Frame_Number'] == 10) {
                        echo '<br>row 1 is: ' . $row['1'];
                        echo '<br>row 2 is: ' . $row['2'];
                        echo '<br>row 3 is: ' . $row['3'];
                        $game->frame(getIntegerNumberOfPinsHitForRollID($row['1']), getIntegerNumberOfPinsHitForRollID($row['2']), getIntegerNumberOfPinsHitForRollID($row['3']));
                    }
                    else {
                        echo '<br>row 1 is: ' . $row['1'];
                        echo '<br>row 2 is: ' . $row['2'];
                        $game->frame(getIntegerNumberOfPinsHitForRollID($row['1']), getIntegerNumberOfPinsHitForRollID($row['2']));
                    }
                }
            }

        }
        echo '<br><br><br><br>';
        $game->stats();
        echo NL;
        echo '<br><br><br><br>';
    }
}

try {
    //    $game = new game;
//    $game->run();
}
catch( \Exception $e ) {
    echo $e->getMessage() . NL;
}

?>