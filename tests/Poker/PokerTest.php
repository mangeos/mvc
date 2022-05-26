<?php

namespace App\Poker;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class PokerTest extends TestCase
{
    /**
     * Test createDeck method - amount of cards should be 52
     *
     */
    public function test_Poker_set_totalPoints()
    {   
        $poker = new Poker("testNamn");
        $poker->setTotalPoints([1,1,1,1,1],[1,1,1,1,1]);
        $totalpoints = $poker->getTotalPoints();
        //$this->assertFalse(new Poker("testNamn"));
        $this->assertEquals($totalpoints, 10);
    }

    /**
     * should be 5 cards after startSetFiveCards() method.
     *
     */
    public function test_startSetFiveCards()
    {   
        $poker = new Poker("testNamn");
        $poker->createDeckAndShuffle();
        $poker->startSetFiveCards();
        $getHorisontalCards = $poker->getHorisontalCards();
        //$this->assertFalse(new Poker("testNamn"));
        $this->assertEquals(count($getHorisontalCards), 5);
    }

    /**
     * should return 1 card.
     *
     */
    public function test_takeOneCard()
    {   
        $poker = new Poker("testNamn");
        $poker->createDeckAndShuffle();
       
        $getHorisontalCards = $poker->takeOneCard();
        //$this->assertFalse(new Poker("testNamn"));
        $this->assertEquals(count($getHorisontalCards), 1);
    }
    
    /**
     * should return an object.
     *
     */
    public function test_getPlayer()
    {   
        $poker = new Poker("testNamn");
        $poker->getPlayer();
        //$this->assertFalse(new Poker("testNamn"));
        $this->assertIsObject($poker->getPlayer());
    }

    /**
     * should return an object.
     *
     */
    public function test_getHorisontalCards()
    {   
        $poker = new Poker("testNamn");
        $poker->createDeckAndShuffle();
        $poker->setHorisontalCards($poker->takeOneCard(), 1);
        //$this->assertFalse(new Poker("testNamn"));
        $this->assertIsArray($poker->getHorisontalCards());
    }
}
