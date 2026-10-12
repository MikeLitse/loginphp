<?php 
    require_once("fixturescalc.php"); //matches table
    require_once("mechanic.php");
    

    function getMatchResults($matchday){
        include("database.php");
    
        $season=getFixtures();
        //$matchday=1; // change this

        try{
            $pdo = new PDO($dsn, $db_user, $db_pass, $options);

            $stmt = $pdo->prepare("CALL update_matches(:result,:home,:away)");

        }catch(Exception $e){
            echo "". $e->getMessage();
        }
        foreach ($season[$matchday] as $game) {
            $home = $game["home"];
            $away = $game["away"];

            echo "${home} <br>";
            echo "${away} <br>";
            $matchesa=0;
            $matchesb= 0;
            $result=calcResult($matchesa,$matchesb);
            
            echo"<br>";

            try{
                
                $stmt->execute([
                    "result" => $result,
                    "home"   => $home,
                    "away"   => $away
                ]);
                while ($stmt->nextRowset()) {}
                $stmt-> closeCursor();
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }

    //getMatchResults();

?>