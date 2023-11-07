<?php
session_start();
require_once('src/Game.php');
class start{
    public function play(){
        $game = new Blackjack(); 
        // $game->placeYourBets();

        // $game->set();
        $game->set();

        //それぞれの選択肢に応じた動作を行わせる
        $game->action();

        $game->resultCalcChips();
        //画面に表示するもの全般
        //引いたカードの情報やヒットスタンドの選択
        $game->showResultMessage();
        }
    }
// }
?>