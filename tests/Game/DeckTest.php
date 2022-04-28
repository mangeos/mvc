<?php

namespace App\Deck;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class DeckTest extends TestCase
{
    /**
     * Test createDeck method - amount of cards should be 52
     *
     */
    public function test_createDeck_lengtOfCards()
    {
        $Deck = new Deck();
        $Deck->createDeck();

        $this->assertEquals(count($Deck->cards), 52);
    }

    public function test_shuffle()
    {
        $DeckBeforeShuffle = new Deck();
        $DeckAfterShuffle = new Deck();
        $DeckAfterShuffle->shuffle();

        $this->assertNotSame($DeckBeforeShuffle, $DeckAfterShuffle);
    }
}
