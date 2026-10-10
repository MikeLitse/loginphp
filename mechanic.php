<?php 
    include("database.php");
    function calcResult(){
        //last 5 matches
        $matchesa = 2;
        $matchesb = 2; 

        //form calculated based on 5 last matches
        $forma=rand(50+$matchesa*5,100)/100;
        echo "Forma: " . $forma . "<br>";
        $oddsa= rand(1,100);
        echo "Oddsa: " . $oddsa . "<br>";
        //final form calculated based on form and odds
        $finalforma=round($forma*$oddsa);

        $formb=rand(50+$matchesb*5,100)/100;
        echo "Formb: ". $formb . "<br>";
        $oddsb= 100-$oddsa;
        echo "Oddsb: " . $oddsb . "<br>";
        $finalformb=round($formb*$oddsb);

        echo "Team A: " . $finalforma . "<br>";
        echo "Team B: " . $finalformb . "<br>";

        $drawodds=100-$finalforma-$finalformb;
        echo "Draw: " . $drawodds . "<br>";
    
        $cond=rand(1,100);
        if($finalforma>$finalformb){
            echo "Cond: " . $cond ."<br>";
            if($cond<=$finalforma){
                echo "P1 wins " . "<br>" ;
                return "P1";
            }else if($cond>100-$finalformb){
                echo "P2 wins " . "<br>";
                return "P2";
            }else{
                echo "Draw ". "<br>";
                return "DRAW";
            }
        }else{
            echo "Cond: " . $cond ."<br>";
            if($cond<=$finalformb){
                echo "P2 wins " . "<br>" ;
                return "P2";
            }else if($cond>100-$finalforma){
                echo "P1 wins " . "<br>";
                return "P1";
            }else{
                echo "Draw ". "<br>";
                return "DRAW";
            }
        }
    }

    echo calcResult();
?>