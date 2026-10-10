<?php 
    include("database.php");    

    //round robin algorithm
    //there is no way one team doesnt play 2 matches at home 

    try{
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        $stmt = $pdo->prepare("SELECT * FROM matches");

        $stmt->execute([]);

        $teams= $stmt->fetchAll(PDO::FETCH_COLUMN); //fetches only columns

        $stmt-> closeCursor();

        //$columns = array_keys($teams[0]);

        $totalTeams= count($teams); //total teams =20
        $totalRounds=$totalTeams-1; //rounds per half =19 

        $matchesPerRound=$totalTeams/2; //matches per round =10

        $season= []; //initialize array;

        //Generate the 1st half of the league (Until Winter)

        $roundTeams= $teams; //made to rotate

        for($round= 0; $round<$totalRounds; $round++){
            $matchdayNum= $round+1; //calc matchday number

            $season[$matchdayNum] = []; //init the matchlist for this matchday

            for($match= 0; $match<$matchesPerRound; $match++){
                $teamA=$roundTeams[$match];//=0 fixed team
                $teamB=$roundTeams[$totalTeams-1-$match];//=20-1-0=19

                if($match === 0){
                    //on even matchdays fixed team plays home
                    //on odd matchdays fixed team plays away
                    if($round %2 === 0){
                        $home=$teamA;
                        $away=$teamB;
                    }else{
                        $home = $teamB;
                        $away = $teamA;
                    }
                }else{
                    // do the same for every other match on the match day
                    //(the other 9)
                    if($match + $round %2 === 0){
                        $home=$teamA;
                        $away=$teamB;
                    }else{
                        $home = $teamB;
                        $away = $teamA;
                    }
                }
                //add the match (home vs away) on the matchlist of the matchday
                $season[$matchdayNum][] = [
                    "home"=>$home,
                    "away"=>$away
                ];

            }
            $last = array_pop($roundTeams); //take last team
            //insert it in the start so that every team shifts
            array_splice($roundTeams, 1, 0, [$last]); 
        }

        //for the summer half (matchdays 20-38)
        //everything is mirrored
        for ($round = 1; $round <= $totalRounds; $round++) {
            $secondHalfRound = $round + $totalRounds; // Round 1 becomes Round 20
            $season[$secondHalfRound] = [];

            foreach ($season[$round] as $fixture) {
                $season[$secondHalfRound][] = [
                    'home' => $fixture['away'], // Previous away team is now home
                    'away' => $fixture['home']  // Previous home team is now away
                ];
            }
        }

        foreach ($season as $matchday => $fixtures) {
            echo "<h3>Matchday " . $matchday . "</h3>";
            echo "<ul>";
            foreach ($fixtures as $game) {
                echo "<li><strong>" . htmlspecialchars($game['home']) . "</strong> vs " . htmlspecialchars($game['away']) . "</li>";
            }
            echo "</ul>";
        }

        echo "Total teams " . $totalTeams ."";
        

    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>