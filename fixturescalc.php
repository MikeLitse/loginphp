<?php 
    include("database.php");    

    try{
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        $stmt = $pdo->prepare("SELECT * FROM matches");

        $stmt->execute([]);

        $rows= $stmt->fetchAll();

        $columns = array_keys($rows[0]);

        $totalTeams= count($rows); //total teams
        $totalRounds=$totalTeams-1; //rounds per half 

        $matchesPerRound=$totalTeams/2;

        $season= []; //initialize array;

        echo "Total teams " . $totalTeams ."";
        

    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>