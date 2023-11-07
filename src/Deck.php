<?php

class deck{
    //ジョーカーを除く52枚のデッキを作る
    function create_deck(){
        $cards = array();
        $suits = array('spade', 'heart', 'diamond', 'club');
     
        foreach($suits as $suit){
            for($i=1;$i<=13;$i++){
                $cards[] = array(
                    'num' => $i,
                    'suit' => $suit
                );
            }
        }
            shuffle($cards);
            return $cards;
    }

}
?>