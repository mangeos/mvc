<?php

namespace App\Deck;



class DeckWith2Jokers extends Deck
{
      public function addJokers() {
        array_push($this->cards, new \App\Card\Card('&hearts;','Joker', 0) );
        array_push($this->cards, new \App\Card\Card('&diams;','Joker', 0) );
  }

}