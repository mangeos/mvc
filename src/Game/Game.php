<?php

namespace App\Game;

class Game
{
    public $deck;
    public $dealer;
    public $player;
     /**
     * Constructor.
     *
     * @param object $deck
     * @param object $dealer
     * @param object $player
     */
    public function __construct()
    {
        $this->deck = new \App\Deck\Deck();
        $this->dealer = new \App\Player\Player("Dealer", []);
        $this->player = new \App\Player\Player("Player", []);
    }

    public function createDeckAndShuffle()
    {
        //create deck and shuffle
        $this->deck->createDeck();
        $this->deck->shuffle();
    }

    public function takeOneCard($playerOrDealer)
    {
        foreach ($this->deck->cards[0] as $key => $value) {
            # code...
            if ($key == 'value') {
                # code...
                if ($playerOrDealer == $this->player->name) {
                    # code...
                    $this->player->addPoints($value);
                    $this->player->addOneCard(array_splice($this->deck->cards, 0, 1));
                } else {
                    $this->dealer->addPoints($value);
                    $this->dealer->addOneCard(array_splice($this->deck->cards, 0, 1));
                }
            }
        }
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function getDealer()
    {
        return $this->dealer;
    }

    public function calculateWinner()
    {
        if ($this->player->points > 21) {
            # code...
            return $this->dealer->name . "wins!";
        } elseif ($this->dealer->points > 21) {
            # code...
            return $this->player->name . "wins!";
        } else {
            # code...
            if ($this->player->points > $this->dealer->points) {
                # code...
                return $this->player->name . "wins!";
            } else {
                return $this->dealer->name . "wins!";
            }
        }
    }
}
