<?php

namespace App\Poker;

class Poker
{
    private $deck;
    private $dealer;
    private $player;

    private $vertical;
    private $horisontal;
     /**
     * Constructor.
     *
     * @param object $deck
     * @param object $dealer
     * @param object $player
     */
    public function __construct($PlayerName)
    {
        $this->deck = new \App\Deck\Deck();
        $this->player = new \App\Player\Player($PlayerName, []);
    }

    public function create_deck_and_shuffle(): void
    {
        //create deck and shuffle
        $this->deck->createDeck();
        $this->deck->shuffle();
    }

    public function take_one_card($playerOrDealer)
    {
        foreach ($this->deck->cards[0] as $key => $value) {
            # code...
            if ($key == 'value') {
                # code...
                if ($playerOrDealer == $this->player->name) {
                    # code...
                    $this->player->add_points($value);
                    $this->player->add_one_card(array_splice($this->deck->cards, 0, 1));
                } else {
                    $this->dealer->add_points($value);
                    $this->dealer->add_one_card(array_splice($this->deck->cards, 0, 1));
                }
            }
        }
    }

    public function get_player()
    {
        return $this->player;
    }

    public function calculate_winner()
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
