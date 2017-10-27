<?php
namespace bowling;
use mysqli;
define('NL','<br>');

class game {
    private $rolls     = array();
    private $roll      = 1;
    private $frames    = array();
    private $frame     = 1;

    public function roll( $pin_count ) {
        if ( !is_int( $pin_count ) ) {
            throw new \InvalidArgumentException('roll() function requires an integer as an argument');
        }
        if ( $pin_count < 0 || $pin_count > 10 ) {
            throw new \RangeException('roll() function requires an integer between 0 and 10');
        }
        $this->rolls[$this->roll] = $pin_count;
        if ( !isset( $this->frames[$this->frame] ) ) {
            $this->frames[$this->frame] = array();
        }
        $ball = ( count( $this->frames[$this->frame] ) + 1 );
        $this->frames[$this->frame][$ball] = $this->roll;
        if ( $this->frame !== 10 && ( $ball === 2 || $pin_count === 10 ) ) {
            $this->frame++;
        }
        $this->roll++;
    }

    public function frame( $roll_1,$roll_2=false,$roll_3=false ) {
        $this->roll( $roll_1 );
        if ( $roll_1 === 10 ) {
            return;
        }
        if ( $roll_2 === false ) {
            throw new \InvalidArgumentException( 'frame() function requires second parameter if first does not equal ' . 10 );
        }
        $frame = $this->frame;
        $this->roll( $roll_2 );
        if ( $frame !== 10 || ( $roll_1 + $roll_2 ) !== 10 ) {
            return;
        }
        if ( $roll_3 === false ) {
            throw new \InvalidArgumentException( 'frame() function requires third parameter if first two equal ' . 10 );
        }
        $this->roll( $roll_3 );
    }

    private function frame_score( $frame ) {
        $frame = $this->frames[$frame];
        $ball_count = count( $frame );
        $pin_count = 0;
        foreach( $frame as $ball => $roll ) {
            $pin_count += $this->rolls[$roll];
        }
        $bonus_rolls = ( $pin_count === 10 ? ( $ball_count === 2 ? 1 : 2 ) : 0 );
        if ( $bonus_rolls > 0 ) {
            for ( $i=1;$i <= $bonus_rolls;$i++ ) {
                $next_roll = ( $roll + $i );
                if ( !isset( $this->rolls[$next_roll] ) ) {
                    break;
                }
                $pin_count += $this->rolls[$next_roll];
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
        foreach( array_keys( $this->frames ) as $frame ) {
            $score += $this->frame_score( $frame );
            $frames[$frame] = $score;
        }
        return $frames;
    }

    public function stats() {
        echo 'Total Score: ' . $this->score() . NL;
        echo 'Rolls: ' . count( $this->rolls ) . NL;
        echo 'Frames: ' . count( $this->frames ) . NL;
        echo 'Frame Breakdown:' . NL;
        $frames = $this->score_by_frame();
        foreach( $frames as $frame => $score ) {
            echo "\tFrame {$frame}: {$score}" . NL;
        }
    }

    public function run() {
        echo '<br><br><br><br>';

        $game = new game;

        foreach (range(1, 10) as $item) {

            $sql = "SELECT group_concat(Roll_One_ID) as '1', group_concat(Roll_Two_ID) as '2', group_concat(Roll_Three_ID) as '3', Frame_Number FROM Frame where Game_ID = 1 and Player_ID = 1 and Frame_Number = $item;";

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