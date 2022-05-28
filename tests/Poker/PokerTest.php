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

    /**
     * should return 50 in every array
     *
     */
    public function test_calculateHorisontal_FourOfAKind()
    {   
        $poker = new Poker("testNamn");
        $poker->createDeckAndShuffle();

        $card = new \App\Card\Card('&hearts;', '2', 2, 2);
        for ($i=1; $i < 6; $i++) { 
            # code...
            for ($e=0; $e < 5; $e++) { 
                # code...
                $poker->setHorisontalCards($card, $i);
            }
        }

        // Create a mock for the Observer class,
        // only mock the update() method.
        //$observer = $this->getMockBuilder(Poker::class)
          //              ->setConstructorArgs("testNamn") 
            //            ->setMethods(['getHorisontalCards'])
              //          ->getMock();


        
        //$this->assertFalse(new Poker("testNamn"));
        $this->assertEquals($poker->calculateHorisentalt(), [50,50,50,50,50]);
    }

       /**
     * should return 50 in every array
     *
     */
    public function test_calculateHorisontal_OnePair()
    {   
        $poker = new Poker("testNamn");
        $poker->createDeckAndShuffle();

        $card1And2 = new \App\Card\Card('&hearts;', '2', 2, 2);

        $card3 = new \App\Card\Card('&hearts;', '10', 10, 10);
        $card4 = new \App\Card\Card('&hearts;', '7', 7, 7);
        $card5 = new \App\Card\Card('A;', '4', 4, 4);
        for ($i=1; $i < 6; $i++) { 
            # code...
            for ($e=0; $e < 5; $e++) { 
                # code...
                if ($e == 0 or $e == 1) {
                    # code...
                    $poker->setHorisontalCards($card1And2, $i);
                } if ($e == 2) {
                    # code...
                     $poker->setHorisontalCards($card3, $i);
                }if ($e == 3) {
                    $poker->setHorisontalCards($card4, $i);
                    # code...
                }if ($e == 4) {
                    # code...
                    $poker->setHorisontalCards($card5, $i);
                }
            }
        }
        $this->assertEquals($poker->calculateHorisentalt(), [2,2,2,2,2]);
    }

    /**
     * should return 10 in every array triss
     *
     */
    public function test_calculateHorisontal_Triss()
    {   
        $poker = new Poker("testNamn");
        $poker->createDeckAndShuffle();

        $card1And2And3 = new \App\Card\Card('&hearts;', '2', 2, 2);

        $card4 = new \App\Card\Card('&hearts;', '7', 7, 7);
        $card5 = new \App\Card\Card('A;', '4', 4, 4);
        for ($i=1; $i < 6; $i++) { 
            # code...
            for ($e=0; $e < 5; $e++) { 
                # code...
                if ($e == 0 or $e == 1 or $e == 2) {
                    # code...
                    $poker->setHorisontalCards($card1And2And3, $i);
                }if ($e == 3) {
                    $poker->setHorisontalCards($card4, $i);
                    # code...
                }if ($e == 4) {
                    # code...
                    $poker->setHorisontalCards($card5, $i);
                }
                }
            }
            $this->assertEquals($poker->calculateHorisentalt(), [10,10,10,10,10]);
    }
}