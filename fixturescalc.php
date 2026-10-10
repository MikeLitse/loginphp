<?php 
    include("database.php");    

    try{
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        $stmt = $pdo->prepare("SELECT * FROM matches");

        $stmt->execute([]);

        $rows= $stmt->fetchAll();

        $columns = array_keys($rows[0]);

        //print row first then the columns
        foreach ($rows as $row) {
            foreach ($columns as $column) {
                
            }
        }

        $stmt ->closeCursor();

    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>