<?php
class ChipCaliculator{
    function resultCalcChips(){
        if($_SESSION['endgame']===true){
            $player_hand=$_SESSION['player_hand'] ;
            $dealer_hand=$_SESSION['dealer_hand'];
        //手札の総スコアの記録、終了条件の明示
            $calc=new CalcScore();
            $player_total=$calc->calcscore($player_hand);
            $dealer_total=$calc->calcscore($dealer_hand);
    
            $totalMyCoin=$_SESSION['your_having_coin'];
            $betCoin=$_SESSION['your_bet_coin'];
            if(($player_total>$dealer_total&&$player_total<=21)||($player_total<=21&&$dealer_total>21)){
                $totalMyCoin+=$betCoin;
                $_SESSION['your_having_coin']=$totalMyCoin;
                $_SESSION['your_result']='Win';
            }elseif($player_total==$dealer_total&&$player_total<=21){

                $_SESSION['your_result']='Draw';
            }else{
                $totalMyCoin-=$betCoin;
                $_SESSION['your_having_coin']=$totalMyCoin;
                $_SESSION['your_result']='Lose';
            }
        }
    }
}
?>