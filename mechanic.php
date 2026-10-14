<?php 
    function calcResult($matchesa,$matchesb){
        
        //form calculated based on the last 5 matches     
        $forma=rand(50+$matchesa*5,100)/100;
        echo "Forma: " . $forma . "<br>";
        
        $formb=rand(50+$matchesb*5,100)/100;
        echo "Formb: ". $formb . "<br>";
        
        $goalsa=0;
        $goalsb=0;
        for($i= 0;$i<8;$i++){
            $rolla =rand(1,6);
            $rollb =rand(1,6);

            $scoresa=$rolla*$forma;
            $scoresb=$rollb*$formb;

            if($scoresa>4){
                $goalsa++;
            }
            if($scoresb> 4){
                $goalsb++;
            }
        }

        if($goalsa>$goalsb){
            return "1";
        }else if($goalsa<$goalsb){
            return "2";
        }else{
            return "X";
        }
    }
?>