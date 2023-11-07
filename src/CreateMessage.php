<?php

require_once('CalcScore.php');
class CreateMessage{
    function showYourBet(){
        if(!isset($_SESSION['your_bet_coin'])||isset($_GET['continue'])){
        echo 'ベットする金額を入力してください(1から1000までベットできます)<br>
        あなたは'.$_SESSION['your_having_coin'].'コインを持っています';
        echo '<form action="Main.php" method="post" name="bet">
        <input type="text" name="bet" id=""><br>
        <input type="submit" value="送信">
        </form>';
        }elseif($_SESSION['your_bet_coin']>$_SESSION['your_having_coin']){
            echo '掛け金が所持金を超えています！！';
            echo 'ベットする金額を入力してください(1から1000までベットできます)<br>
            あなたは'.$_SESSION['your_having_coin'].'コインを持っています';
            echo '<form action="Main.php" method="post" name="bet">
            <input type="text" name="bet" id=""><br>
            <input type="submit" value="送信">
            </form>';
            exit;
        }
        else{
            echo "あなたは".$_SESSION['your_bet_coin']."コインを賭けています";
        }
    }
    //自分の手札を表示
    function showYourHand(){
        $player_hand=$_SESSION['player_hand'];
        echo '<p>Your Hand: ';
        foreach($player_hand as $card){
            echo "<img src='trump/card_".$card['suit']."_".$card['num'].".png' alt='写真' width='136' height='200'>";
        }
        echo '<br />';
    }
    //自分のスコアを表示、勝敗ドローも明記
    function showYourScore(){
        global $end_game;
        $calc=new CalcScore();
        $player_hand=$_SESSION['player_hand'];
        $dealer_hand=$_SESSION['dealer_hand'];
        $player_total=$calc->calcscore($player_hand);
        $dealer_total=$calc->calcscore($dealer_hand);
        echo 'Total:';
        echo $player_total;
        if($player_total > 21){
            echo ' Burst';
        } elseif($_SESSION['endgame'] === true && ($player_total > $dealer_total||$player_total<=21 &&$dealer_total>21)){
            echo ' Win';
            // if($player_hand[0])
        }elseif($_SESSION['endgame'] === true && ($player_total == $dealer_total)){
            echo 'Draw';
        }
        echo'</p><hr />';
    }
    //ディーラーの手札を表示
    function showDealerHand(){
        // echo "<p>Dealer's Hand:";
        // $dealer_hand=$_SESSION['dealer_hand'];
        // foreach($dealer_hand as $card){
        //     echo "<img src='trump/card_".$card['suit']."_".$card['num'].".png' alt='写真' width='136' height='200'>";
        // }
        // echo '<br />';
        echo "<p>Dealer's Hand:";
        $dealer_hand=$_SESSION['dealer_hand'];
        if($_SESSION['endgame'] === false){
            $firstcard=array_shift($dealer_hand);
            echo "<img src='trump/card_".$firstcard['suit']."_".$firstcard['num'].".png' alt='写真' width='136' height='200'>";
            echo "<img src='trump/card_back.png' alt='写真' width='136' height='200'>";
        }elseif($_SESSION['endgame'] === true){
        foreach($dealer_hand as $card){
            echo "<img src='trump/card_".$card['suit']."_".$card['num'].".png' alt='写真' width='136' height='200'>";
        }
        echo '<br />';
        }
    }
    //ディーラーの合計スコアを表示、結果も明記
    function showDealerScore(){
        echo 'Total:';
        $calc=new CalcScore();
        $player_total=$calc->calcscore($_SESSION['player_hand']);
        if($_SESSION['endgame'] === false){

            $dealer_total=$calc->calcscore($_SESSION['dealer_hand']);
        }
        if($_SESSION['endgame'] === true){
            $dealer_total=$calc->calcscore($_SESSION['dealer_hand']);
        }
        echo $dealer_total;
            if($dealer_total > 21){
            echo ' Burst';
        } else if($_SESSION['endgame'] === true && $dealer_total > $player_total){
            echo ' Win';
        }elseif($_SESSION['endgame'] === true && ($player_total == $dealer_total)){
            echo 'Draw';
        }
    
        echo'</p>
     
        <hr/>';
        }
        //ヒット、スタンド、そしてリセットボタンを表示する
        function displaySelectButton(){
            echo'<ul>';
            if($_SESSION['endgame'] === false){
                echo'<li><a href="?hit">Hit</a></li>
                <li><a href="?stand">Stand</a></li>';
                if(count($_SESSION['player_hand'])==2){
                echo '<li><a href="?doubledown">DoubleDown</a></li>';
                }
            }
            if($_SESSION['endgame'] === true){
                echo '<li><a href="?continue">NextGame</a></li>';
            }
             echo '<li><a href="?reset">Reset</a></li></ul>';
        }

        function showGameResult(){
            if($_SESSION['endgame'] === true &&  $_SESSION['your_having_coin']!=0){
                switch($_SESSION['your_result']){
                    case 'Win':
                        echo 'あなたの勝ちです、'.$_SESSION['your_bet_coin'].'コインを得ました<br>今の所持金は'.$_SESSION['your_having_coin'].'です';
                        break;
                    case 'Lose':
                        echo 'あなたの負けです、'.$_SESSION['your_bet_coin'].'コインを失いました<br>今の所持金は'.$_SESSION['your_having_coin'].'です';
                        break;
                    case 'Draw':
                        echo '引き分けでした、'.$_SESSION['your_bet_coin'].'コインは持ち越しです<br>今の所持金は'.$_SESSION['your_having_coin'].'です';
                        break;
                }
            }


            if($_SESSION['endgame'] === true &&  $_SESSION['your_having_coin']==0){
                echo '所持金がなくなりました、ゲームオーバーです。';
            }
        } 
}
?>