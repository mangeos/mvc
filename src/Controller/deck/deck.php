<?php

namespace App\Controller;



class Deck
{
/**
 * Constructor to create a Deck.
 *
 */
public function __construct()
{
    $this->cards = [];
}

public function createDeck() {
    $suits = ['&hearts', '&diams', '&clubs', '&spades'];
    $ranks = ['ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'jack', 'queen', 'king'];
    $values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];

    for ($i = 0; $i < count($suits); $i++) {
        for ($j = 0; $j < count($ranks); $j++) {
           array_push($this->cards, new \App\Controller\Card($suits[$i], $ranks[$j], $values[$j]));
        }
    }
}

public function shuffle(){
    shuffle( $this->cards);
}
    
}

