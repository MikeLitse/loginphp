<?php
    include("database.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <form class="header">
        <h2>Hello
            <?php echo htmlspecialchars($_SESSION["username"])?>    
            this is the home page
        </h2>
        <h2>
            <?php echo htmlspecialchars($_SESSION["msg"])?>
        </h2>
        <a href="index.php">Logout</a>
    </form>
    <div>
        <?php
            try{
                $pdo = new PDO($dsn, $db_user, $db_pass, $options);

                $stmt = $pdo->prepare("CALL get_premier_league()");

                $stmt->execute();

                $rows = $stmt->fetchAll();

                $i=0;

                foreach($rows as $row){
                    echo "<p>". $i+1 . " " . $rows[$i]["teamname"] . "</p>";
                    $i++;
                }

                $stmt->closeCursor();

            }catch (PDOException $e) {
                echo "Error: Returning teams" . $e->getMessage();
            }
        ?>
    </div>
</body>
</html>