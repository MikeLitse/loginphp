<?php 
    require_once("fixturescalc.php"); //matches table
    require_once("mechanic.php"); 
    function getMatchResults($matchday, $season) {
        if (!isset($season[$matchday])) {
            echo "No matches found for Matchday " . htmlspecialchars($matchday);
            return;
        }

        echo "<h3>Matchday " . htmlspecialchars($matchday) . " Results:</h3>";
        echo "<ul>";

        $matchResultsTable= [];

        foreach ($season[$matchday] as $game) {
            $result = calcResult(0, 0); // $result[0] is home goals, $result[1] is away goals

            $matchResultsTable[] = [
                'home'       => $game['home'],
                'away'       => $game['away'],
                'homescore' => $result[0],
                'awayscore' => $result[1]
            ];
        }

        echo "<ul>";
        foreach ($matchResultsTable as $game) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($game['home']) . "</strong> ";
            echo htmlspecialchars($game['homescore']) . " - " . htmlspecialchars($game['awayscore']) . " ";
            echo "<strong>" . htmlspecialchars($game['away']) . "</strong>";
            echo "</li>";
        }
        
        return $matchResultsTable;

    }

    function updateMatches($matchResultsTable){
        include("database.php");
        try{
            $pdo = new PDO($dsn, $db_user, $db_pass, $options);

            $stmt = $pdo->prepare("CALL update_matches(:home,:away,:homescore,:awayscore)");

            foreach($matchResultsTable as $game){
                $home = $game["home"];
                $away = $game["away"];
                $homescore = $game["homescore"];
                $awayscore = $game["awayscore"];
                
                $stmt->execute([
                        "home"   => $home,
                        "away"   => $away,
                        "homescore" =>$homescore,
                        "awayscore"=>$awayscore
                ]);
                while ($stmt->nextRowset()) {}
                $stmt-> closeCursor();

                echo"insertion success";
            }
        }catch(Exception $e){
            echo "Error updating the table". $e->getMessage();
        }
    }
    
    /*matchResultsTable
    [
    0 => [
        'home'       => 'AFC Bournemouth',
        'away'       => 'Tottenham Hotspur',
        'home_score' => 2,
        'away_score' => 1
    ],
    1 => [
        'home'       => 'Everton FC',
        'away'       => 'Ipswich Town',
        'home_score' => 0,
        'away_score' => 0
    ],
    
    ]
    */

?>

