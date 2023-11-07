<?php

require_once('CalcScore.php');
class Player_action{

    function selectHit(){
        if(isset($_GET['hit'])){
            $player_hand=$_SESSION['player_hand'];
            $deck=$_SESSION['deck'];
            $player_hand[]=array_shift($deck);
            $_SESSION['player_hand']=$player_hand;
            $_SESSION['deck']=$deck;
        }
    }
//スタンドしたときの動作、自分はカードを引かずディーラーが17以上になるまで引き続ける
    function selectStand(){
        global $end_game;
        if(isset($_GET['stand'])){
            $deck=$_SESSION['deck'];
            $dealer_hand=$_SESSION['dealer_hand'];
            $under_hit=17;
            $calc=new CalcScore;
            while($calc->calcscore($dealer_hand)<$under_hit){
                $dealer_hand[]=array_shift($deck);
            }
            $_SESSION['dealer_hand']=$dealer_hand;
            $_SESSION['deck']=$deck;
            $_SESSION['endgame']=true;
        }
    }

    function selectDoubleDown(){
        global $end_game;
        if(isset($_GET['doubledown'])){
            $player_hand=$_SESSION['player_hand'];
            $deck=$_SESSION['deck'];
            $player_hand[]=array_shift($deck);
            $_SESSION['player_hand']=$player_hand;
            //ディーラーが17以上になるまで引き続ける
            $dealer_hand=$_SESSION['dealer_hand'];
            $under_hit=17;
            $calc=new CalcScore;
            while($calc->calcscore($dealer_hand)<$under_hit){
                $dealer_hand[]=array_shift($deck);
            }
            $_SESSION['dealer_hand']=$dealer_hand;
            $_SESSION['deck']=$deck;
            $_SESSION['endgame']=true;
            $_SESSION['your_having_coin']-=$_SESSION['your_bet_coin'];
            $_SESSION['your_bet_coin']*=2;
        }
    }
    //スコアがオーバーしたときの動作
function scoreOver(){
    if(isset($_SESSION['player_hand'])){
        global $end_game;
        $player_hand=$_SESSION['player_hand'] ;
        $dealer_hand=$_SESSION['dealer_hand'];
    //手札の総スコアの記録、終了条件の明示
        $calc=new CalcScore();
        $player_total=$calc->calcscore($player_hand);
        $dealer_total=$calc->calcscore($dealer_hand);

        if($player_total > 21 || $dealer_total > 21){
            $_SESSION['endgame'] = true;
        }
    }
}
}
?>