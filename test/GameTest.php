<?php
require 'src/game.php';
class GameTest extends PHPUnit_Framework_TestCase {
    /** @test */
    public function canaryTest() {
        $this->assertTrue(true);
    }

    /** @test */
    public function testPerfectGameReturns300() {
        $game = new \bowling\game();

        foreach (range(1, 12) as $roll) {
            $game->frame(10);
        }
        $this->assertTrue($game->score() == 300);
    }

    /** @test */
    public function testFoulGameReturnsZero() {
        $game = new \bowling\game();
        foreach (range(1, 12) as $roll) {
            $game->frame(0, 0);
        }
        $this->assertTrue($game->score() == 0);
    }

    /** @test */
    public function testNormalGameReturns83() {
        $game = new \bowling\game();
        $game->frame(9,0);
        $game->frame(4,5);
        $game->frame(6,1);
        $game->frame(3,6);
        $game->frame(8,1);
        $game->frame(5,3);
        $game->frame(2,5);
        $game->frame(8,0);
        $game->frame(7,1);
        $game->frame(8,1);
        $this->assertTrue($game->score() == 83);
    }

    /** @test */
    public function testIncompleteGameReturns10() {
        $game = new \bowling\game();
        $game->frame(9,0);
        $game->frame(0,1);
        $this->assertTrue($game->score() == 10);
    }

    /** @test */
    public function testIncompleteGameReturns0() {
        $game = new \bowling\game();
        $this->assertTrue($game->score() == 0);
    }

    /** @test */
    public function testCompleteWithThreeRollsOnTenthFrame() {
        $game = new \bowling\game();
        $game->frame(9,0);
        $game->frame(3,7);
        $game->frame(6,1);
        $game->frame(3,7);
        $game->frame(8,1);
        $game->frame(5,5);
        $game->frame(0,10);
        $game->frame(8,0);
        $game->frame(7,3);
        $game->frame(8,2,8);
        $this->assertTrue($game->score() == 131);
    }
}