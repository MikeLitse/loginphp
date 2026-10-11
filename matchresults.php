<?php 
    require_once("fixturescalc.php");
    require_once("mechanic.php");

    function getMatchResults(){
        
        $season=getFixtures();
        $matchday=1;
        foreach ($season[$matchday] as $game) {
            $home = htmlspecialchars($game["home"]);
            $away = htmlspecialchars($game["away"]);

            echo "${home} <br>";
            echo "${away} <br>";
            $matchesa=0;
            $matchesb= 0;
            calcResult($matchesa,$matchesb);
            
            echo"<br>";

        }

    }

    getMatchResults();
?>