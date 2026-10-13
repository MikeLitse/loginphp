<?php 
    include("database.php");
    function calcResult($matchesa,$matchesb){
        //last 5 matches matchesa and matchesb
        //form calculated based on 5 last matches
        $forma=rand(50+$matchesa*5,100)/100;
        echo "Forma: " . $forma . "<br>";
        //$oddsa= rand(1,100);
        //echo "Oddsa: " . $oddsa . "<br>";
        //final form calculated based on form and odds
        //$finalforma=round($forma*$oddsa);

        $formb=rand(50+$matchesb*5,100)/100;
        echo "Formb: ". $formb . "<br>";
        //$oddsb= 100-$oddsa;
        //echo "Oddsb: " . $oddsb . "<br>";
        //$finalformb=round($formb*$oddsb);

        //echo "Team A: " . $finalforma . "<br>";
        //echo "Team B: " . $finalformb . "<br>";

        //$drawodds=100-$finalforma-$finalformb;
        //echo "Draw: " . $drawodds . "<br>";

        $cond=rand(1,100);
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
            echo "Draw ". "<br>";
            return "1";
        }else if($goalsa<$goalsb){
            return "2";
        }else{
            return "X";
        }
        
    }
    

    //echo calcResult();
?>