<?php

namespace App\Card;


class Card
{
/**
 * Constructor to create a Card.
 *
 * @param string $suit   The suit of the card.
 * @param string $rank   The rank of the card.
 * @param int    $value  The value of the value.
 */
public function __construct(string $suit, string $rank, int $value)
{
    $this->suit = $suit;
    $this->rank = $rank;
    $this->value = $value;
}
    
}
