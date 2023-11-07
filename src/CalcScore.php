<?php

    class CalcScore{
        function calcscore($hands){
            $ace = 0;
            $total = 0;
            foreach($hands as $card){
                $num = $card['num'];
                if($num > 10){
                    $total += 10;
                } else if($num === 1){
                    $ace++;
                    $total += 1;
                } else {
                    $total += $num;
                }
            }
            //Aの処理
            if(!empty($ace)){
                $add = 10 * floor( (21 - $total) / 10 );
                if($add > 0) $total += $add;
            }
            return $total;
        }
    }
?>