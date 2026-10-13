<?php 
require_once("fixturescalc.php");
require_once("mechanic.php");

function getMatchResults($matchday, $season) {
    if (!isset($season[$matchday]) || $matchday > 38) {
        return;
    }

    include("database.php");

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
        $stmt = $pdo->prepare("CALL update_matches(:result, :home, :away)");

        foreach ($season[$matchday] as $game) {
            $home = $game["home"];
            $away = $game["away"];

            $matchesa = 0;
            $matchesb = 0;
            $matchresult = calcResult($matchesa, $matchesb);

            if ($matchresult[0] > $matchresult[1]) {
                $result = "1";
            } elseif ($matchresult[0] < $matchresult[1]) {
                $result = "2";
            } else {
                $result = "X";
            }

            try {
                $stmt->execute([
                    "result" => $result,
                    "home"   => $home,
                    "away"   => $away
                ]);

                while ($stmt->nextRowset()) {} // Clear stored procedure buffers
            } catch (Exception $e) {
                // Silently write to error log so no output breaks HTTP headers
                error_log("Query failed for match {$home} vs {$away}: " . $e->getMessage());
            }
        }
        
        $stmt->closeCursor();

    } catch (PDOException $e) {
        error_log("Connection failed in getMatchResults: " . $e->getMessage());
    }
}