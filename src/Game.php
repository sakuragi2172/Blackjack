<?php


require_once('Player_action.php');
require_once('CreateMessage.php');
require_once('CalcScore.php');
require_once('FirstSetting.php');
require_once('ChipCaliculator.php');

Class Blackjack{

    //初期設定、初手２枚をそれぞれに配る、ベット額を決める
    function set(){
        $_SESSION['endgame']=false;
        $setting=new FirstSetting();
        //リセットを選択したときにすべてのセッションデータを消す
        $setting->selectReset();
        $setting->selectContinue();
        $setting->getChip();
        $setting->firstDealCard();

    }

    //  それぞれのボタン、ヒットスタンドダブルダウンを選択した時の動作
    function action(){
        $action=new Player_action();
        $action->selectHit();
        $action->selectStand();
        $action->selectDoubleDown();
        $action->scoreOver();
    }


    function resultCalcChips(){
        $calc=new ChipCaliculator();
        $calc->resultCalcChips();
    }
    function showResultMessage(){
        $message=new CreateMessage();

        $message->showYourBet();
        if(isset($_SESSION['your_bet_coin'])){
            //現在の手札と総得点数を示す
            $message->showYourHand();
            $message->showYourScore();
            //現在の手札と総得点数を示す
            $message->showDealerHand();
            $message->showDealerScore();
            
            $message->showGameResult();
            $message->displaySelectButton();

            }       
        }
}
?>