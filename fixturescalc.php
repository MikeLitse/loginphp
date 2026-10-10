<?php 
    include("database.php");    

    try{
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        $stmt = $pdo->prepare("SELECT * FROM matches");

        $stmt->execute([]);

        $rows= $stmt->fetchAll();

        $columns = array_keys($rows[0]);

        //print row first then the columns
        $i=1;
        foreach ($rows as $row) {
            if($row["TEAMS"]!=$columns[$i]){
                echo"Matchday: " . $i;
            }
            $i++;
            foreach ($columns as $column) {
                
            }
        }

        $opponentColumns = array_filter($columns, fn($col) => $col !== 'TEAMS');

        $matchday = 1;

        foreach ($rows as $row) {
            $homeTeam = $row['TEAMS'];
            echo "<h3>Home: " . htmlspecialchars($homeTeam) . "</h3>";

            foreach ($opponentColumns as $awayTeam) {
                
                if ($homeTeam !== $awayTeam) {
                    echo $matchday . ": " . $homeTeam . " vs " . $awayTeam . "<br>";
                    $matchday++;
                }
            }
            echo "<hr>";
        }

        $stmt ->closeCursor();

    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>