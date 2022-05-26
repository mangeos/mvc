<?php

namespace App\Player;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class PlayerTest extends TestCase
{
    /**
     * Test createDeck method - amount of cards should be 52
     *
     */
    public function test_PlayerClass_attribute()
    {
        $this->assertClassHasAttribute("name", Player::class, "Playerclass dont have attribute name");
    }

    public function test_add_one_card_AddOne()
    {
        $TestName = "testName";
        $TestArray = [];

        $Player = new Player($TestName, $TestArray);
        $Player->addOneCard("oneCard");

        $this->assertEquals(count($Player->playerCards), 1);
    }

    public function test_add_points_AddOne()
    {
        $TestName = "testName";
        $TestArray = [];

        $Player = new Player($TestName, $TestArray);
        $Player->addPoints(1);

        $this->assertEquals($Player->points, 1);
    }
}
