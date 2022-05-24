<?php

namespace App\Poker;

class Poker
{
    private $deck;
    private $dealer;
    private $player;
    private $points;

    private $verticalCards;
    private $horisontalCards;
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
        $this->pointsVerticals = [];
        
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


    public function calculate_horisentalt()
    {
        $cards = $this->get_horisontalCards();
        $suitHand = [];
        $valueHand = [];

        for ($i=1; $i < 6; $i++) { 
            foreach ($cards[$i] as $key => $value) {
                # hand row1
                if ($i == 1) {
                   for ($e=0; $e < count($cards[$i]); $e++) {
                        # code...
                        array_push($suitHand, $cards[$i][$e]->suit);
                        array_push($valueHand, $cards[$i][$e]->pokerValue);
                    }
                     #kollar royal flush, straight flush, stege och färg
                     $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                     #1. Royal flush            -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                     #2. straight flush         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                     #3. Four of a kind         -- yes pairs_checker
                     #4. Full house 3 & 2 par   -- no
                     #5. färg flush             -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                     #6. straight stege         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                     #7. triss                  -- yes pairs_checker
                     #8. 2 två par'             -- yes two_pairs($valueHand)
                     #9. 1 par                  -- yes pairs_checker
                    // if(){

                     //}
                    
                }
                # hand row1
                if ($i == 2) {
                    # code...
                }
                # hand row1
                if ($i == 3) {
                    # code...
                }
                # hand row1
                if ($i == 4) {
                    # code...
                }
                # hand row1
                if ($i == 5) {
                    # code...
                }
            }
        }
    }
     public function royal_flush_or_straight_flush_checker($suitHand, $valueHand)
    {
		  // hög stege
		  $högStege = $this->straight_checker($valueHand);
		  if($högStege == "högsta stege"){
			  //kollar färg true/false
			  $trueOrFalse = $this->flush_checker($suitHand);
			  if($trueOrFalse == true){
				    return "ROYAL FLUSH";
                }
                return "stege";
		  }
		  if($högStege == "stege"){
			  $trueOrFalse = $this->flush_checker($suitHand);
			  if($trueOrFalse==true){
				  return "STRAIGHT FLUSH";
			  }
              return "stege";
		  }
		  if($högStege == "ingen stege"){
			  $trueOrFalse = $this->flush_checker($suitHand);
			  if($trueOrFalse==true){
				  return "färg";
			  }
		  }
		  return "inget";
    }
    public function pairs_checker($valueHand)
    {
	  sort($valueHand);
	    if(count($valueHand) == 5 ){
		  if($valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3] || 
            $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3] && $valueHand[3] == $valueHand[4] ){
		  	return "4";
		  }
			if($valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2] || 
                $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3] || 
                $valueHand[2] == $valueHand[3] && $valueHand[3] == $valueHand[4] ){
				return "3";
			}
			if($valueHand[0] == $valueHand[1] || 
                $valueHand[1] == $valueHand[2] || 
                $valueHand[2] == $valueHand[3] || 
                $valueHand[3] == $valueHand[4] ){
				return "2";
			}
		}
	  	    if(count($valueHand) == 4 ){
		  if($valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3]){
		  	return "4";
		  }
			if($valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2] || 
                $valueHand[1] == $valueHand[2] && $valueHand[2] == $valueHand[3]){
				return "3";
			}
			if($valueHand[0] == $valueHand[1] || 
                $valueHand[1] == $valueHand[2] || 
                $valueHand[2] == $valueHand[3] ){
				return "2";
			}
		}
	  	    if(count($valueHand) == 3 ){
		  if($valueHand[0] == $valueHand[1] && $valueHand[1] == $valueHand[2]){
		  	return "3";
		  }
			if($valueHand[0] == $valueHand[1] || 
                $valueHand[1] == $valueHand[2] ){
				return "2";
			}
		}
	   	    if(count($valueHand) == 2 ){
			if($valueHand[0] == $valueHand[1] ){
				return "2";
			}
		}
	  return "inga par";
	 
    }

    public function check_three(int $x, int $y, int $z){
	if ($x == $y || $x == $z || $y==$z){
		return 1;
	}
	else{
		return 0;
	}
}

    public function two_pairs($valueHand)
    {
	  sort($valueHand);
	    if(count($valueHand) == 5 ){
		 	$a = $valueHand[0];
			$b = $valueHand[1];
			$c = $valueHand[2];
			$d = $valueHand[3];
			$e = $valueHand[4];
			if ( ($a==$b) && ($this->check_three($c,$d,$e) ==1 ) ){
			return "två par";
		}
		else if( ($a==$c) && ($this->check_three($b,$d,$e) ==1 ) ){
			return "två par";
		}
		else if( ($a==$d) && ($this->check_three($c,$b,$e) ==1 ) ){
			return "två par";
		}
		else if( ($a==$e) && ($this->check_three($b,$c,$d) ==1 ) ){
			return "två par";
		}
		else if( ($b==$c) && ($this->check_three($a,$d,$e) ==1 ) ){
			return "två par";
		}
		else if( ($b==$d) && ($this->check_three($a,$c,$e) ==1 ) ){
			return "två par";
		}
		else if( ($b==$e) && ($this->check_three($a,$c,$d) ==1 ) ){
			return "två par";
		}
		else if( ($c==$d) && ($this->check_three($a,$b,$e) ==1 ) ){
			return "två par";
		}
		else if( ($c==$e) && ($this->check_three($a,$b,$d) ==1 ) ){
			return "två par";
		}
		else if( ($d==$e) && ($this->check_three($a,$b,$c) ==1 ) ){
			return "två par";
		}
		else{
			return "no";
		}
		
		}
	  	    if(count($valueHand) == 4 ){
		  if($valueHand[0] == $valueHand[1] && $valueHand[2] == $valueHand[3] && $valueHand[0] != $valueHand[3]){
		  	return "två par";
		  }
		
		}
	  	return "no";
	 
    }

    public function flush_checker($hand)
    {
        // same suits
        $counter=0;
        for ($r=1; $r < count($hand); $r++) {
            if ($hand[0]==$hand[$r]) {
                # code...
                $counter+=1;
                if ($counter == 4) {
                # code...
                   return "true";
               }
        }
        }
        return "false";
	
    }

   public function straight_checker($hand){
     // same suits
		# code...
	sort($hand);
	$counter=1;
	for ($e=1; $e < 5; $e++) {
		# code...
		if ($hand[$e] == $hand[$e-1]+1) {
			# code...
			$counter+=1;
			if($counter==5){ 
				if($hand[0] == 10){
					return "högsta stege";
				}
				return "stege";
			}
		}
		
	}
	return "ingen stege";
}

    public function calculate_verticalt()
    {
        $cards = $this->get_horisontalCards();
        for ($i=0; $i < 5 ; $i++) { 
            # code...
           // var_dump($cards[1][$i]);
            for ($e=1; $e < 6; $e++) { 
                # code...
                if (isset($cards[$e][$i]->rank)){
                    var_dump(($cards[$e][$i]->rank));
                }
                if ($e == 5) {
                    # code...
                    var_dump($e);   
                }
            }
        }
       
    }
}