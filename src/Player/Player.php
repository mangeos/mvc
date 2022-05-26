<?php

namespace App\Player;

class Player
{
    public $name;
    public $playerCards;

    /**
     * Constructor to create a Card.
     *
     * @param string $suit   The suit of the card.
     * @param string $rank   The rank of the card.
     */
    public function __construct(string $name, array $playerCards)
    {
        $this->name = $name;
        $this->playerCards = $playerCards;
        $this->points = 0;
    }
    public function addOneCard($oneCard)
    {
        array_push($this->playerCards, $oneCard);
    }

    public function addPoints(int $point)
    {
        $this->points += $point;
    }
}
