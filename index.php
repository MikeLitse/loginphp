<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    
</body>
</html>

<?php 
    include("database.php");
?>

<?php 
    echo "hi there ";

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);

        $stmt = $pdo->query("CALL get_users()");

        $rows = $stmt->fetchAll();

        foreach($rows as $row){
            echo "User:" . $row["username"] . " Password:" . $row["pass"] . " Email:" . $row["email"] . "<br>";
        }

        $stmt->closeCursor();

    }catch (PDOException $e) {
        echo "Error: Returning users" . $e->getMessage();
    }

    try{
        //$pdo = new PDO($dsn, $db_user, $db_pass, $options);
        $username="Giwrgos";
        $password= "GiwrgosLitse";
        $email="giwrgos@litse.com";

        //$stmt = $pdo->prepare("CALL insert_user(:username,:password,:email)");

        //$stmt->execute([
            //':username' => $username,
            //':password'=> $password,
            //':email' => $email
        //]);

        //$stmt->closeCursor();
        //echo "User added";

    }catch(PDOException $e) {
        echo "Error Inserting User " . $e->getMessage();
    }


?>