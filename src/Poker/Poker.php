<?php

namespace App\Poker;

class Poker
{
    private $deck;
    private $player;

    private $verticalCards;
    private $horisontalCards;
    private $totalPoints;

    public $pointsHorisontal;
    public $pointsVertical;
    //private $pointsHorisental;
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
        $this->pointsHorisontal = [0,0,0,0,0];
        $this->pointsVertical = [0,0,0,0,0];
        $this->totalPoints = 0;
    }

    public function setTotalPoints(array $pointsH, array $pointsV)
    {
        $this->totalPoints = 0;
        for ($i = 0; $i < 5; $i++) {
            # code...
            $this->totalPoints = $this->totalPoints + $pointsH[$i] + $pointsV[$i];
        }
    }

    public function getTotalPoints()
    {
        return $this->totalPoints;
    }

    public function createDeckAndShuffle(): void
    {
        //create deck and shuffle
        $this->deck->createDeck();
        $this->deck->shuffle();
    }

    public function startSetFiveCards(): void
    {
        $fiveCards = array_splice($this->deck->cards, 0, 5);
        # push cards in to verticalcards at first element
        //var_dump($fiveCards[0]);
        # push cards in to horisontalcards, one card each
        for ($i = 0; $i < 5; $i++) {
            # code...
            $this->setHorisontalCards($fiveCards[$i], $i + 1);
            $this->setVerticalCards($fiveCards[$i], "1");
        }
    }

    public function takeOneCard()
    {
        $oneCard = array_splice($this->deck->cards, 0, 1);
        $this->player->addOneCard($oneCard);
        return $oneCard;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function setVerticalCards($verticalCard, $n)
    {
        array_push($this->verticalCards[$n], $verticalCard);
    }

    public function getVerticalCards()
    {
        return $this->verticalCards;
    }

    public function setHorisontalCards($horisontalCard, $n)
    {
        array_push($this->horisontalCards[$n], $horisontalCard);
    }

    public function getHorisontalCards()
    {
        return $this->horisontalCards;
    }



    public function calculateHorisentalt()
    {
        $cards = $this->getHorisontalCards();
        for ($i = 1; $i < 6; $i++) {
            foreach ($cards[$i] as $key => $value) {
                $suitHand = [];
                $valueHand = [];
                # hand row1
               
                    for ($e = 0; $e < count($cards[$i]); $e++) {
                        # code...
                        array_push($suitHand, $cards[$i][$e]->suit);
                        array_push($valueHand, $cards[$i][$e]->pokerValue);
                    }
                   // var_dump($valueHand);
                    # kollar fyra, triss och par
                    $pairsChecker = $this->pairsChecker($valueHand);

                    #kollar royal flush, straight flush
                    $royalFlush = $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);

                    #kollar färg
                    $flush = $this->flushChecker($suitHand);

                    #kollar stege
                    $stege = $this->straightChecker($valueHand);

                     #kollar full house
                    $fullHouse = $this->fullHouse($valueHand);

                    #kollar 2 par
                    $twoPairs = $this->twoPairs($valueHand);
                    #9. 1 par                  -- yes pairsChecker
                    if ($pairsChecker == "2") {
                        $this->pointsHorisontal[$i - 1] = 2;
                    }
                    #8. 2 två par'             -- yes twoPairs($valueHand)
                    if ($twoPairs == "två par") {
                        $this->pointsHorisontal[$i - 1] = 5;
                    }
                   #7. triss                  -- yes pairsChecker
                    if ($pairsChecker == "3") {
                        $this->pointsHorisontal[$i - 1] = 10;
                    }
                   #6. straight stege         -- yes $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);
                    if ($stege == "stege" || $stege == "högsta stege") {
                        $this->pointsHorisontal[$i - 1] = 15;
                    }
                   #5. färg flush             -- yes $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);
                    if ($flush == "true") {
                        $this->pointsHorisontal[$i - 1] = 20;
                    }
                   #4. Full house 3 & 2 par   -- yes fullHouse
                    if ($fullHouse == "yes") {
                        # code...
                        $this->pointsHorisontal[$i - 1] = 25;
                    }

                   #3. Four of a kind         -- yes pairsChecker
                    if ($pairsChecker == "4") {
                        $this->pointsHorisontal[$i - 1] = 50;
                    }
                   #2. straight flush         -- yes $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);
                    if ($royalFlush == "STRAIGHT FLUSH") {
                        $this->pointsHorisontal[$i - 1] = 75;
                    }
                    #1. Royal flush            -- yes $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);
                    if ($royalFlush == "ROYAL FLUSH") {
                        $this->pointsHorisontal[$i - 1] = 100;
                    }
            }
        }
        return $this->pointsHorisontal;
    }

    public function royalFlushOrStraightFlushChecker($suitHand, $valueHand)
    {
         // hög stege
         $högStege = $this->straightChecker($valueHand);
        if ($högStege == "högsta stege") {
            //kollar färg true/false
            $trueOrFalse = $this->flushChecker($suitHand);
            if ($trueOrFalse == true) {
                  return "ROYAL FLUSH";
            }
              return "stege";
        }
        if ($högStege == "stege") {
            $trueOrFalse = $this->flushChecker($suitHand);
            if ($trueOrFalse == true) {
                return "STRAIGHT FLUSH";
            }
            return "stege";
        }
        if ($högStege == "ingen stege") {
            $trueOrFalse = $this->flushChecker($suitHand);
            if ($trueOrFalse == true) {
                return "färg";
            }
        }
         return "inget";
    }

    public function pairsChecker($valueHand)
    {
        sort($valueHand);
        if (count($valueHand) == 5) {
            if (
                $valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3] ||
                $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3] && $valueHand[3] == $valueHand[4]
            ) {
                return "4";
            }
            if (
                $valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2] ||
                $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3] ||
                $valueHand[2] == $valueHand[3] && $valueHand[3] == $valueHand[4]
            ) {
                return "3";
            }
            if (
                $valueHand[0] == $valueHand[1] ||
                $valueHand[1] == $valueHand[2] ||
                $valueHand[2] == $valueHand[3] ||
                $valueHand[3] == $valueHand[4]
            ) {
                return "2";
            }
        }
        if (count($valueHand) == 4) {
            if ($valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3]) {
                return "4";
            }
            if (
                $valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2] ||
                $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3]
            ) {
                return "3";
            }
            if (
                $valueHand[0] == $valueHand[1] ||
                $valueHand[1] == $valueHand[2] ||
                $valueHand[2] == $valueHand[3]
            ) {
                return "2";
            }
        }
        if (count($valueHand) == 3) {
            if ($valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2]) {
                return "3";
            }
            if (
                $valueHand[0] == $valueHand[1] ||
                $valueHand[1] == $valueHand[2]
            ) {
                return "2";
            }
        }
        if (count($valueHand) == 2) {
            if ($valueHand[0] == $valueHand[1]) {
                return "2";
            }
        }
        return "inga par";
    }

    public function fullHouse($data)
    {
        if (count($data) != 5) {
            return "no";
        }
        sort($data);
        $counter = 0;
        for ($i = 1; $i < 5; $i++) {
            if ($data[$i - 1] == $data[$i]) {
                $counter += 1;
                if ($counter == 2 && $data[1] != $data[3]) {
                    $counter = 0;
                    for ($i = 1; $i < 5; $i++) {
                        if ($data[$i - 1] == $data[$i]) {
                            $counter += 1;
                            if ($counter == 3) {
                                return "yes";
                            }
                        }
                    }
                }
            }
        }
        return "no";
    }


    public function checkThree(int $x, int $y, int $z)
    {
        if ($x == $y || $x == $z || $y == $z) {
            return 1;
        } else {
            return 0;
        }
    }

    public function twoPairs($valueHand)
    {
        sort($valueHand);
        if (count($valueHand) == 5) {
            $a = $valueHand[0];
            $b = $valueHand[1];
            $c = $valueHand[2];
            $d = $valueHand[3];
            $e = $valueHand[4];
            if (($a == $b) && ($this->checkThree($c, $d, $e) == 1 )) {
                return "två par";
            } elseif (($a == $c) && ($this->checkThree($b, $d, $e) == 1 )) {
                return "två par";
            } elseif (($a == $d) && ($this->checkThree($c, $b, $e) == 1 )) {
                return "två par";
            } elseif (($a == $e) && ($this->checkThree($b, $c, $d) == 1 )) {
                return "två par";
            } elseif (($b == $c) && ($this->checkThree($a, $d, $e) == 1 )) {
                return "två par";
            } elseif (($b == $d) && ($this->checkThree($a, $c, $e) == 1 )) {
                return "två par";
            } elseif (($b == $e) && ($this->checkThree($a, $c, $d) == 1 )) {
                return "två par";
            } elseif (($c == $d) && ($this->checkThree($a, $b, $e) == 1 )) {
                return "två par";
            } elseif (($c == $e) && ($this->checkThree($a, $b, $d) == 1 )) {
                return "två par";
            } elseif (($d == $e) && ($this->checkThree($a, $b, $c) == 1 )) {
                return "två par";
            } else {
                return "no";
            }
        }
        if (count($valueHand) == 4) {
            if ($valueHand[0] == $valueHand[1] && $valueHand[2] == $valueHand[3] && $valueHand[0] != $valueHand[3]) {
                return "två par";
            }
        }
        return "no";
    }

    public function flushChecker($hand)
    {
        // same suits
        if (count($hand) != 5) {
            return "false";
        }
        $counter = 0;
        for ($r = 1; $r < count($hand); $r++) {
            if ($hand[0] == $hand[$r]) {
                # code...
                $counter += 1;
                if ($counter == 4) {
                # code...
                    return "true";
                }
            }
        }
        return "false";
    }

    public function straightChecker($hand)
    {
     // same suits
        # code...
        if (count($hand) != 5) {
            return "ingen stege";
        }
        sort($hand);
        $counter = 1;


        for ($e = 0; $e < 5; $e++) {
            # code...
            if ($e == 4 && $hand[3] == $hand[4] - 1) {
                if ($hand[0] == 10) {
                    return "högsta stege";
                }
                return "stege";
            }
            if ($hand[$e] != $hand[$e + 1] - 1) {
                return "ingen stege";
            }
        }
    }

    public function calculateVerticalt()
    {
        $cards = $this->getHorisontalCards();
        for ($i = 0; $i < 5; $i++) {
            # code...
           // var_dump($cards[1][$i]);
            $handValues = [];
            $handSuits = [];
            for ($e = 1; $e < 6; $e++) {
                # code...
                if (isset($cards[$e][$i]->rank)) {
                  //  var_dump(($cards[$e][$i]->rank));
                    array_push($handValues, $cards[$e][$i]->pokerValue);
                    array_push($handSuits, $cards[$e][$i]->suit);
                 //   var_dump($handSuits);
                }
            }
             //var_dump($handSuits);
             #här skickar jag en vertikal hand i taget
            #---------------------------------------------------------------
               # kollar fyra, triss och par
            $pairsChecker = $this->pairsChecker($handValues);

            #kollar royal flush, straight flush
            $royalFlush = $this->royalFlushOrStraightFlushChecker($handSuits, $handValues);

            #kollar färg
            $flush = $this->flushChecker($handSuits);

            #kollar stege
            $stege = $this->straightChecker($handValues);

             #kollar full house
            $fullHouse = $this->fullHouse($handValues);

            #kollar 2 par
            $twoPairs = $this->twoPairs($handValues);

            #9. 1 par                  -- yes pairsChecker
            if ($pairsChecker == "2") {
                $this->pointsVertical[$i] = 2;
            }
            #8. 2 två par'             -- yes twoPairs($valueHand)
            if ($twoPairs == "två par") {
                $this->pointsVertical[$i] = 5;
            }
            #7. triss                  -- yes pairsChecker
            if ($pairsChecker == "3") {
                $this->pointsVertical[$i] = 10;
            }
            #6. straight stege         -- yes $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);
            if ($stege == "stege" || $stege == "högsta stege") {
                $this->pointsVertical[$i] = 15;
            }
            #5. färg flush             -- yes $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);
            if ($flush == "true") {
                $this->pointsVertical[$i] = 20;
            }
            #4. Full house 3 & 2 par   -- no
            if ($fullHouse == "yes") {
                $this->pointsVertical[$i] = 25;
            }
            #3. Four of a kind         -- yes pairsChecker
            if ($pairsChecker == "4") {
                $this->pointsVertical[$i] = 50;
            }
            #2. straight flush         -- yes $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);
            if ($royalFlush == "STRAIGHT FLUSH") {
                $this->pointsVertical[$i] = 75;
            }
            #1. Royal flush            -- yes $this->royalFlushOrStraightFlushChecker($suitHand, $valueHand);
            if ($royalFlush == "ROYAL FLUSH") {
                $this->pointsVertical[$i] = 100;
            }
            #----------------------------------------------------------------
        }
        return $this->pointsVertical;
    }
}
