<?php

namespace App\Card;

class Card
{
    public $suit;
    public $rank;
    public $value;
    public $pokerValue;
    /**
     * Constructor to create a Card.
     *
     * @param string $suit   The suit of the card.
     * @param string $rank   The rank of the card.
     * @param int    $value  The value of the value.
     * @param int    $pokerValue  The pokerValue of the pokerValue.
     */
    public function __construct(string $suit, string $rank, int $value, int $pokerValue)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->value = $value;
        $this->pokerValue = $pokerValue;
    }
}
