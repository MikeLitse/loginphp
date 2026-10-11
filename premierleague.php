<?php
    include("database.php"); //these get executed no matter what when you enter or refresh the page
    include("mechanic.php");
    
    session_start();

    require_once("fixturescalc.php");
    if(!isset($_SESSION["season"])){
        $_SESSION["season"]= getFixtures(); //they get a value only one time
    }
    if(!isset($_SESSION["matchday"])){
        $_SESSION["matchday"]= 1; //they get a value only one time
    }
    
    if (!isset($_SESSION["username"])){ //they get a value only one time
        die("user is not logged in");
    }else{
        $username = $_SESSION["username"];
    }

    try{

        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        $stmt = $pdo->prepare("CALL get_user_by_name(:username)");

        $stmt->execute([
            "username"=> $username
        ]);

        $rows= $stmt->fetchAll();

        if(!empty($rows)){
            $selectedteam = $rows[0]["team"];
        }

        $stmt->closeCursor();

    }catch(PDOException $e){
        die("". $e->getMessage());
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["selected_team"])) {
        $selectedteam = trim($_POST["selected_team"]);
        
        try{

            $pdo = new PDO($dsn, $db_user, $db_pass, $options);

            $stmt = $pdo->prepare("UPDATE users SET team=:selectedteam WHERE username=:username");

            $stmt->execute([
                "selectedteam"=>$selectedteam,
                "username"=>$username
            ]);

            $stmt->closeCursor();

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST["next"])) {
        require_once("matchresults.php");
        getMatchResults();

        header("Location: " . $_SERVER['PHP_SELF']); //redirect to the same page
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="tableindex.css">

</head>

<body>
    <div class= "divcontainer">
        <nav class="navbar">
            <ul class="nav-links">
                <li class="nav-link">
                    <a href="homepage.php">Home</a>
                </li>
                <li class="nav-link drop">
                    <a href="#">Leagues</a>
                    <ul class="drop-down">
                        <li><a href="premierleague.php">Premier League</a></li>
                        <li><a href="#">La Liga</a></li>
                    </ul>
                </li>
                <li class="nav-link">
                    <a href="#">About</a>
                </li>
                <li class="nav-link">
                    <a href="#">Contact</a>
                </li>    
            </ul>
        </nav>
    </div>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <input type="hidden" name="selected_team" id="selected_team_input">
        <div class="card">
            <?php
                try{
                    //create the table
                    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
                    $stmt = $pdo->prepare("CALL get_premier_league()");
                    $stmt->execute();

                    // Fetch strictly associative array to avoid numeric duplicate columns
                    $rows = $stmt->fetchAll();

                    if (!empty($rows)) {
                        $columns = array_keys($rows[0]);

                        echo '<table class="tablebody">';
                    
                        echo '<thead><tr>';
                        echo '<th>#</th>';
                        foreach ($columns as $col) {
                            echo '<th>' . htmlspecialchars(ucwords(str_replace('_', ' ', $col))) . '</th>';
                        }
                        echo '</tr></thead>';

                        echo '<tbody>';
                        $pos = 1;
                        foreach ($rows as $row) {
                            //this is an if case that appends $isSelected= rowsel if the row
                            //macthes the selected team name else it appends null
                            $isSelected = ($selectedteam === $row["teamname"]) ? ' rowsel' : '';

                            echo '<tr class="tablerow' . $isSelected . '" data-teamname="' . htmlspecialchars($row["teamname"]) . '">';

                            echo '<td name=${pos}>' . $pos++ . '</td>';

                            foreach ($columns as $col) {
                                $alignClass = ($col === 'teamname') ? 'team-cell' : 'stat-cell';
                                echo '<td class="' . $alignClass  . ' ">' . htmlspecialchars($row[$col]) . '</td>';
                            }
                            echo '</tr>';
                        }
                        echo '</tbody>';

                        echo '</table>';
                    }

                    $stmt->closeCursor();

                }catch (PDOException $e) {
                    echo "Error: Returning teams" . $e->getMessage();
                }            
            ?>
            
            <button type="submit" name="next" class="btn">Next MatchDay</button>

        </div>
        <div>
            <?php
            //init the fixtures
                foreach ($_SESSION["season"] as $matchday => $fixtures) {
                    echo "<h3>Matchday " . $matchday . "</h3>";
                    echo "<ul>";
                    foreach ($fixtures as $game) {
                        echo "<li><strong>" . htmlspecialchars($game['home']) . "</strong> vs " . htmlspecialchars($game['away']) . "</li>";
                    }
                echo "</ul>";
                }
            ?>
        </div>    
    </form>
    
    <script>
        //This is for the page on browser side (doesnt recall the fav team)
        const inputField = document.getElementById('selected_team_input');

        document.querySelectorAll('.tablerow').forEach(row => {
            row.addEventListener('click', () => {
                
                document.querySelectorAll('.tablerow').forEach(r => r.classList.remove('rowsel'));

                row.classList.add('rowsel');

                const teamName = row.dataset.teamname;
                inputField.value = teamName;
            });
        });
    </script>
    
</body>
</html>