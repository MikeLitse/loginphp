<?php 
    include("database.php");
    
    function calcResult($matchesa,$matchesb){
        //last 5 matches matchesa and matchesb

        //form calculated based on 5 last matches
        $forma=rand(50+$matchesa*10,100)/100;
        
        //for the second team
        $formb=rand(50+$matchesb*10,100)/100;
        
        //final form calculated based on form and odds
        //$finalforma=$forma; //*($oddsa);
        //$finalformb=$formb; //*($oddsb);

        echo "Team A: " . $forma . "<br>";
        echo "Team B: " . $formb . "<br>";

        //what is left out is the draw odds
        //$drawodds=100-$finalforma-$finalformb;
        //echo "Draw: " . $drawodds . "<br>";
    
        $cond=rand(1,100);
        $scoreda=0;
        $scoredb=0;
        //implement a dice roll mechanic
        for($i= 0; $i<8; $i++){
            $rolla=rand(1,6);
            $rollb=rand(1,6);
            echo" rolla: " . $rolla;
            echo" rollb: " . $rollb;


            $goala=$rolla*$forma;
            $goalb=$rollb*$formb;
            echo " GoalA: " . $goala;
            echo " GoalB: " . $goalb;

            if($goala>4){
                $scoreda++;
                echo " A scored ";
            }
            if($goalb>4){
                $scoredb++;
                echo " B scored ";
            }

            echo "<br>";
        }
        
        echo "" . $scoreda . " - " . $scoredb;
        //need to calculate the result

        return "";

    }

    echo "" . calcResult(5,1);
?>