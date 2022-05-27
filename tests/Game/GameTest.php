<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game.
 */
class GameTest extends TestCase
{
    /**
     * Test if deck is an object
     *
     */

    public function test_ifdeckisobject()
    {
        $Game = new Game();
        $this->assertIsObject($Game->deck);
    }

      public function test_ifdealerisobject()
    {
        $Game = new Game();
        $this->assertIsObject($Game->dealer);
    }

        public function test_ifplayerisobject()
    {
        $Game = new Game();
        $this->assertIsObject($Game->player);
    }


        public function test_get_player()
    {
        $Game = new Game();
        $this->assertIsObject($Game->getPlayer());
    }

    public function test_get_dealer()
    {
        $Game = new Game();
        $this->assertIsObject($Game->getDealer());
    }
}