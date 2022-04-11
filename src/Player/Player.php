<?php

namespace App\Player;


class Player
{
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
    
}

}