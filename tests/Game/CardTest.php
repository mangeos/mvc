<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Test createDeck method - amount of cards should be 52
     *
     */
    public function test_CardClass_attribute()
    {
        $this->assertClassHasAttribute("suit", Card::class, "Cardclass dont have attribute suit");
    }
}
