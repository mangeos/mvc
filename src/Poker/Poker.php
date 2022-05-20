<?php

namespace App\Poker;

class Poker
{
    private $deck;
    private $dealer;
    private $player;

    private $verticalCards;
    private $horisontalCards;
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

        $this->verticalCards = ["1" => [], "2" => [], "3" => [], "4" => [], "5" => []];
        $this->horisontalCards = [1 => [], 2 => [], 3 => [], 4 => [], 5 => []];
    }

    public function create_deck_and_shuffle(): void
    {
        //create deck and shuffle
        $this->deck->createDeck();
        $this->deck->shuffle();
    }

    public function start_set_five_cards(): void
    {
        $fiveCards = array_splice($this->deck->cards, 0, 5);
        # push cards in to verticalcards at first element
        //var_dump($fiveCards[0]);
        # push cards in to horisontalcards, one card each
        for ($i=0; $i < 5; $i++) { 
            # code...
            $this->set_horisontalCards($fiveCards[$i], $i+1);
            $this->set_verticalCards($fiveCards[$i], "1");
        }
    }

    public function take_one_card()
    {
        $oneCard = array_splice($this->deck->cards, 0, 1);
        $this->player->add_one_card($oneCard);
        return $oneCard;
    
    }

    public function get_player()
    {
        return $this->player;
    }

    public function set_verticalCards($verticalCard, $n)
    {
        array_push($this->verticalCards[$n], $verticalCard);
    }

    public function get_verticalCards() 
    {
        return $this->verticalCards;
    }

    public function set_horisontalCards($horisontalCard, $n)
    {
        array_push($this->horisontalCards[$n], $horisontalCard);
    }

    public function get_horisontalCards() 
    {
        return $this->horisontalCards;
    }


    public function calculate()
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
