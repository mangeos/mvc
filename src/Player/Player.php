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
    $this->points = 0;
    
}
public function add_one_card($oneCard)
{
    array_push($this->playerCards, $oneCard);

}

public function add_points(int $point)
{
    $this->points += $point;

}


}