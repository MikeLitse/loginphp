<?php
    include("database.php");

    $selectedteam='';
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["selected_team"])) {
        $selectedteam = $_POST["selected_team"];
    }
    echo $selectedteam;
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
    
    <form method="post" action="">
        <div class="card">
            <?php
                try{
                    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
                    $stmt = $pdo->prepare("CALL get_premier_league()");
                    $stmt->execute();

                    // Fetch strictly associative array to avoid numeric duplicate columns
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($rows)) {
                        $columns = array_keys($rows[0]);

                        echo '<table class="tablebody">';
                    
                        //Table Header
                        echo '<thead><tr>';
                        echo '<th>#</th>'; // Position column
                        foreach ($columns as $col) {
                            echo '<th>' . htmlspecialchars(ucwords(str_replace('_', ' ', $col))) . '</th>';
                        }
                        echo '</tr></thead>';

                        //Table Body
                        echo '<tbody>';
                        $pos = 1;
                        foreach ($rows as $row) {
                            echo '<tr class="tablerow" data-teamname="' . htmlspecialchars($row["teamname"]) . '">';
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
        </div>
    </form>
    <button name="selectteam">Select team</button>

    <script>
        document.querySelectorAll('.tablerow').forEach(row => {
            row.addEventListener('click', () => {
                const teamName= row.dataset.teamname;
                alert("Selected Team: " + teamName);
            })
        })
    </script>
    
</body>
</html>