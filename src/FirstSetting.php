<?php
require_once('Deck.php');
class FirstSetting{
    //すべてのセッションを空白にする
    function selectReset(){
        if(isset($_GET['reset'])){
        $_SESSION=array();  
        $_SESSION['endgame']=false;
        }
    }
    //所持金を残してすべてリセットされる
    function selectContinue(){
        if(isset($_GET['continue'])){
            unset($_SESSION['your_bet_coin']);
            unset($_SESSION['player_hand']);
            unset($_SESSION['dealer_hand']);
            unset($_SESSION['deck']);
        }
    }
    function firstDealCard(){
        if(isset($_SESSION['deck'])&& !isset($_GET['reset'])){
            $deck=$_SESSION['deck'];
        }else{
            $create=new deck();
            $deck=$create->create_deck();
            //初期手札2枚を配る
            $player_hand[]=array_shift($deck);
            $player_hand[]=array_shift($deck);
            $dealer_hand[]=array_shift($deck);
            $_SESSION['player_hand']=$player_hand;
            $_SESSION['dealer_hand']=$dealer_hand;
            $_SESSION['deck']=$deck;
        }
    }
    function getChip(){
        $havingCoin=0;
        if(isset($_SESSION['your_having_coin'])){
            $havingCoin=$_SESSION['your_having_coin'];
        }
        if(empty($_SESSION['your_having_coin'])&&$havingCoin==0){
            $_SESSION['your_having_coin']=100;
        }
        if(!empty($_REQUEST['bet'])){
            $_SESSION['your_bet_coin']=$_REQUEST['bet']; 
            }
    }
}
?>