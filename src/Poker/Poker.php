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
        $this->pointsHorisontal = [0,0,0,0,0];
        $this->pointsVertical = [0,0,0,0,0];
        
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
        
        for ($i=1; $i < 6; $i++) { 
            foreach ($cards[$i] as $key => $value) {
                $suitHand = [];
                $valueHand = [];
                # hand row1
                if ($i == 1) {
                   for ($e=0; $e < count($cards[$i]); $e++) {
                        # code...
                        array_push($suitHand, $cards[$i][$e]->suit);
                        array_push($valueHand, $cards[$i][$e]->pokerValue);
                    }
                   // var_dump($valueHand);
                    # kollar fyra, triss och par
                    $pairsChecker = $this->pairs_checker($valueHand);
                    
                    #kollar royal flush, straight flush
                    $royalFlush = $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);

                    #kollar färg 
                    $flush = $this->flush_checker($suitHand);

                    #kollar stege
                    $stege = $this->straight_checker($valueHand);

                     #kollar full house
                    $fullHouse = $this->full_house($valueHand);
                    
                    #kollar 2 par
                    $twoPairs = $this->two_pairs($valueHand);
                    
                    #9. 1 par                  -- yes pairs_checker
                    if($pairsChecker == "2"){
                        $this->pointsHorisontal[$i-1] = 2;
                    }
                    #8. 2 två par'             -- yes two_pairs($valueHand)
                   if($twoPairs == "två par"){
                       $this->pointsHorisontal[$i-1] = 5;
                   }
                   #7. triss                  -- yes pairs_checker
                   if($pairsChecker == "3"){
                       $this->pointsHorisontal[$i-1] = 10;
                   }
                   #6. straight stege         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($stege == "stege" || $stege == "högsta stege"){
                       $this->pointsHorisontal[$i-1] = 15;
                   }
                   #5. färg flush             -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($flush == "true"){
                       $this->pointsHorisontal[$i-1] = 20;
                   }
                   #4. Full house 3 & 2 par   -- yes full_house
                   if ($fullHouse == "yes") {
                       # code...
                       $this->pointsHorisontal[$i-1] = 25;
                   }
                   
                   #3. Four of a kind         -- yes pairs_checker
                   if($pairsChecker == "4"){
                       $this->pointsHorisontal[$i-1] = 50;
                   }
                   #2. straight flush         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($royalFlush == "STRAIGHT FLUSH"){
                       $this->pointsHorisontal[$i-1] = 75;
                    }
                    #1. Royal flush            -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                    if($royalFlush == "ROYAL FLUSH"){
                        $this->pointsHorisontal[$i-1] = 100;
                    }
                }
                # hand row1
                if ($i == 2) {
                     for ($e=0; $e < count($cards[$i]); $e++) {
                        # code...
                        array_push($suitHand, $cards[$i][$e]->suit);
                        array_push($valueHand, $cards[$i][$e]->pokerValue);
                    }

                    # kollar fyra, triss och par
                    $pairsChecker = $this->pairs_checker($valueHand);
                    
                    #kollar royal flush, straight flush
                    $royalFlush = $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);

                    #kollar färg 
                    $flush = $this->flush_checker($suitHand);

                    #kollar stege
                    $stege = $this->straight_checker($valueHand);

                     #kollar full house
                    $fullHouse = $this->full_house($valueHand);

                    #kollar 2 par
                    $twoPairs = $this->two_pairs($valueHand);
                    
                   #9. 1 par                  -- yes pairs_checker
                    if($pairsChecker == "2"){
                        $this->pointsHorisontal[$i-1] = 2;
                    }
                    #8. 2 två par'             -- yes two_pairs($valueHand)
                   if($twoPairs == "två par"){
                       $this->pointsHorisontal[$i-1] = 5;
                   }
                   #7. triss                  -- yes pairs_checker
                   if($pairsChecker == "3"){
                       $this->pointsHorisontal[$i-1] = 10;
                   }
                   #6. straight stege         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($stege == "stege" || $stege == "högsta stege"){
                       $this->pointsHorisontal[$i-1] = 15;
                   }
                   #5. färg flush             -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($flush == "true"){
                       $this->pointsHorisontal[$i-1] = 20;
                   }
                    #4. Full house 3 & 2 par   -- yes full_house
                   if ($fullHouse == "yes") {
                       # code...
                       $this->pointsHorisontal[$i-1] = 25;
                   }
                   #3. Four of a kind         -- yes pairs_checker
                   if($pairsChecker == "4"){
                       $this->pointsHorisontal[$i-1] = 50;
                   }
                   #2. straight flush         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($royalFlush == "STRAIGHT FLUSH"){
                       $this->pointsHorisontal[$i-1] = 75;
                    }
                    #1. Royal flush            -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                    if($royalFlush == "ROYAL FLUSH"){
                        $this->pointsHorisontal[$i-1] = 100;
                    }
                }
                # hand row1
                if ($i == 3) {
                     for ($e=0; $e < count($cards[$i]); $e++) {
                        # code...
                        array_push($suitHand, $cards[$i][$e]->suit);
                        array_push($valueHand, $cards[$i][$e]->pokerValue);
                    }

                    # kollar fyra, triss och par
                    $pairsChecker = $this->pairs_checker($valueHand);
                    
                    #kollar royal flush, straight flush
                    $royalFlush = $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);

                    #kollar färg 
                    $flush = $this->flush_checker($suitHand);

                    #kollar stege
                    $stege = $this->straight_checker($valueHand);

                     #kollar full house
                    $fullHouse = $this->full_house($valueHand);

                    #kollar 2 par
                    $twoPairs = $this->two_pairs($valueHand);
                    
                   #9. 1 par                  -- yes pairs_checker
                    if($pairsChecker == "2"){
                        $this->pointsHorisontal[$i-1] = 2;
                    }
                    #8. 2 två par'             -- yes two_pairs($valueHand)
                   if($twoPairs == "två par"){
                       $this->pointsHorisontal[$i-1] = 5;
                   }
                   #7. triss                  -- yes pairs_checker
                   if($pairsChecker == "3"){
                       $this->pointsHorisontal[$i-1] = 10;
                   }
                   #6. straight stege         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($stege == "stege" || $stege == "högsta stege"){
                       $this->pointsHorisontal[$i-1] = 15;
                   }
                   #5. färg flush             -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($flush == "true"){
                       $this->pointsHorisontal[$i-1] = 20;
                   }
                   #4. Full house 3 & 2 par   -- yes full_house
                   if ($fullHouse == "yes") {
                       # code...
                       $this->pointsHorisontal[$i-1] = 25;
                   }
                   
                   #3. Four of a kind         -- yes pairs_checker
                   if($pairsChecker == "4"){
                       $this->pointsHorisontal[$i-1] = 50;
                   }
                   #2. straight flush         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($royalFlush == "STRAIGHT FLUSH"){
                       $this->pointsHorisontal[$i-1] = 75;
                    }
                    #1. Royal flush            -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                    if($royalFlush == "ROYAL FLUSH"){
                        $this->pointsHorisontal[$i-1] = 100;
                    }
                }
                # hand row1
                if ($i == 4) {
                     for ($e=0; $e < count($cards[$i]); $e++) {
                        # code...
                        array_push($suitHand, $cards[$i][$e]->suit);
                        array_push($valueHand, $cards[$i][$e]->pokerValue);
                    }

                    # kollar fyra, triss och par
                    $pairsChecker = $this->pairs_checker($valueHand);
                    
                    #kollar royal flush, straight flush
                    $royalFlush = $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);

                    #kollar färg 
                    $flush = $this->flush_checker($suitHand);

                    #kollar stege
                    $stege = $this->straight_checker($valueHand);

                     #kollar full house
                    $fullHouse = $this->full_house($valueHand);

                    #kollar 2 par
                    $twoPairs = $this->two_pairs($valueHand);
                    
                  #9. 1 par                  -- yes pairs_checker
                    if($pairsChecker == "2"){
                        $this->pointsHorisontal[$i-1] = 2;
                    }
                    #8. 2 två par'             -- yes two_pairs($valueHand)
                   if($twoPairs == "två par"){
                       $this->pointsHorisontal[$i-1] = 5;
                   }
                   #7. triss                  -- yes pairs_checker
                   if($pairsChecker == "3"){
                       $this->pointsHorisontal[$i-1] = 10;
                   }
                   #6. straight stege         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($stege == "stege" || $stege == "högsta stege"){
                       $this->pointsHorisontal[$i-1] = 15;
                   }
                   #5. färg flush             -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($flush == "true"){
                       $this->pointsHorisontal[$i-1] = 20;
                   }
                    #4. Full house 3 & 2 par   -- yes full_house
                   if ($fullHouse == "yes") {
                       # code...
                       $this->pointsHorisontal[$i-1] = 25;
                   }
                   
                   #3. Four of a kind         -- yes pairs_checker
                   if($pairsChecker == "4"){
                       $this->pointsHorisontal[$i-1] = 50;
                   }
                   #2. straight flush         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($royalFlush == "STRAIGHT FLUSH"){
                       $this->pointsHorisontal[$i-1] = 75;
                    }
                    #1. Royal flush            -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                    if($royalFlush == "ROYAL FLUSH"){
                        $this->pointsHorisontal[$i-1] = 100;
                    }
                }
                # hand row1
                if ($i == 5) {
                    for ($e=0; $e < count($cards[$i]); $e++) {
                        # code...
                        array_push($suitHand, $cards[$i][$e]->suit);
                        array_push($valueHand, $cards[$i][$e]->pokerValue);
                    }

                    # kollar fyra, triss och par
                    $pairsChecker = $this->pairs_checker($valueHand);
                    
                    #kollar royal flush, straight flush
                    $royalFlush = $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);

                    #kollar färg 
                    $flush = $this->flush_checker($suitHand);

                    #kollar stege
                    $stege = $this->straight_checker($valueHand);

                     #kollar full house
                    $fullHouse = $this->full_house($valueHand);

                    #kollar 2 par
                    $twoPairs = $this->two_pairs($valueHand);
                    
                    #9. 1 par                  -- yes pairs_checker
                    if($pairsChecker == "2"){
                        $this->pointsHorisontal[$i-1] = 2;
                    }
                    #8. 2 två par'             -- yes two_pairs($valueHand)
                   if($twoPairs == "två par"){
                       $this->pointsHorisontal[$i-1] = 5;
                   }
                   #7. triss                  -- yes pairs_checker
                   if($pairsChecker == "3"){
                       $this->pointsHorisontal[$i-1] = 10;
                   }
                   #6. straight stege         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($stege == "stege" || $stege == "högsta stege"){
                       $this->pointsHorisontal[$i-1] = 15;
                   }
                   #5. färg flush             -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($flush == "true"){
                       $this->pointsHorisontal[$i-1] = 20;
                   }
                    #4. Full house 3 & 2 par   -- yes full_house
                   if ($fullHouse == "yes") {
                       # code...
                       $this->pointsHorisontal[$i-1] = 25;
                   }
                   
                   #3. Four of a kind         -- yes pairs_checker
                   if($pairsChecker == "4"){
                       $this->pointsHorisontal[$i-1] = 50;
                   }
                   #2. straight flush         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                   if($royalFlush == "STRAIGHT FLUSH"){
                       $this->pointsHorisontal[$i-1] = 75;
                    }
                    #1. Royal flush            -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
                    if($royalFlush == "ROYAL FLUSH"){
                        $this->pointsHorisontal[$i-1] = 100;
                    }
                }
            }
        }
        return $this->pointsHorisontal;
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

    public function full_house($data)
 {
	 if(count($data) != 5){
	 	return "no";
	 }
	 sort($data);
	 $counter = 0;
	 for($i=1; $i < 5; $i++){
		 if($data[$i-1] == $data[$i]){
			 $counter+=1;
			 if($counter==2 && $data[1] != $data[3]){
				 $counter = 0;
				 for($i=1; $i < 5; $i++){
					 if($data[$i-1] == $data[$i]){
						 $counter+=1;
						 if($counter==3){
							return "yes";
						 }
					 }
				 }
			 }	 
		 }
	 }
	 return "no";
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
	   if(count($hand) != 5){
		return "false";}
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
		if(count($hand) != 5){
		return "ingen stege";}
		sort($hand);
		$counter=1;
			
		
		for ($e=0; $e < 5; $e++) {
			# code...
			if($e == 4 && $hand[3] == $hand[4]-1){
				if($hand[0] == 10){
					return "högsta stege";
				}
				return "stege";
			}
			if ($hand[$e] != $hand[$e+1]-1) {
				return "ingen stege";		
		}
		
		}
	}

    public function calculate_verticalt()
    {
        $cards = $this->get_horisontalCards();
        for ($i=0; $i < 5 ; $i++) { 
            # code...
           // var_dump($cards[1][$i]);
           $handValues = [];
           $handSuits = [];
            for ($e=1; $e < 6; $e++) { 
                # code...
                if (isset($cards[$e][$i]->rank)){
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
            $pairsChecker = $this->pairs_checker($handValues);
            
            #kollar royal flush, straight flush
            $royalFlush = $this->royal_flush_or_straight_flush_checker($handSuits, $handValues);

            #kollar färg 
            $flush = $this->flush_checker($handSuits);

            #kollar stege
            $stege = $this->straight_checker($handValues);

             #kollar full house
            $fullHouse = $this->full_house($handValues);

            #kollar 2 par
            $twoPairs = $this->two_pairs($handValues);
            
            #9. 1 par                  -- yes pairs_checker
            if($pairsChecker == "2"){
                $this->pointsVertical[$i] = 2;
            }
            #8. 2 två par'             -- yes two_pairs($valueHand)
            if($twoPairs == "två par"){
                $this->pointsVertical[$i] = 5;
            }
            #7. triss                  -- yes pairs_checker
            if($pairsChecker == "3"){
                $this->pointsVertical[$i] = 10;
            }
            #6. straight stege         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
            if($stege == "stege" || $stege == "högsta stege"){
                $this->pointsVertical[$i] = 15;
            }
            #5. färg flush             -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
            if($flush == "true"){
                $this->pointsVertical[$i] = 20;
            }
            #4. Full house 3 & 2 par   -- no
             if($fullHouse == "yes"){
                $this->pointsVertical[$i] = 25;
            }
            #3. Four of a kind         -- yes pairs_checker
            if($pairsChecker == "4"){
                $this->pointsVertical[$i] = 50;
            }
            #2. straight flush         -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
            if($royalFlush == "STRAIGHT FLUSH"){
                $this->pointsVertical[$i] = 75;
            }
            #1. Royal flush            -- yes $this->royal_flush_or_straight_flush_checker($suitHand, $valueHand);
            if($royalFlush == "ROYAL FLUSH"){
                $this->pointsVertical[$i] = 100;
            }
            #----------------------------------------------------------------
            
        }
        return $this->pointsVertical;
    }
}