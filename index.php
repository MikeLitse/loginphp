<?php 
    include("database.php");
    $found = null;
?>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username= $_POST["username"];
        $password= $_POST["password"];

        if(empty($username) || empty($password)){
            echo "Please enter all the required";
        }else{
            try{
                $pdo = new PDO($dsn, $db_user, $db_pass, $options);

                $stmt = $pdo->prepare("CALL get_user_by_name(:username)");

                $stmt->execute([
                    "username"=> $username,
                ]);

                $rows = $stmt->fetchAll();

                if(empty($rows)){
                    echo "<script>alert('User not found!');</script>";
                }

                if($rows["0"]["pass"]===$password){
                    echo "<script>alert('Right password!');</script>";
                }else{
                    echo "<script>alert('Wrong password!');</script>";
                }


                
            /*
            foreach($rows as $row){
                echo "User:" . $row["username"] . " Password:" . $row["pass"] . " Email:" . $row["email"] . "<br>";
            }
            */
            $stmt->closeCursor();
            }catch (PDOException $e) {
                echo "Error: Returning users" . $e->getMessage();
            }
        }
    }
    /*get_users()
    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        $stmt = $pdo->query("CALL get_users()");

        $rows = $stmt->fetchAll();

        $stmt->closeCursor();

    }catch (PDOException $e) {
        echo "Error: Returning users" . $e->getMessage();
    }
    */
    /*insert_user()
    try{
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
        $username="Giwrgos";
        $password= "GiwrgosLitse";
        $email="giwrgos@litse.com";

        $stmt = $pdo->prepare("CALL insert_user(:username,:password,:email)");

        $stmt->execute([
            ':username' => $username,
            ':password'=> $password,
            ':email' => $email
        ]);

        $stmt->closeCursor();
        echo "User added";

    }catch(PDOException $e) {
        echo "Error Inserting User " . $e->getMessage();
    }
    */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h1>Login</h1>
        <div>
            <h2>Username:</h2>
            <input type="text" name="username">
        </div>
        <div>
            <h2>Password:</h2>
            <input type="password" name="password">
        </div>
        <div>
            <input type="submit" value="login" name="submit">
        </div>
        
    </form>
</body>
</html>