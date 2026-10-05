<?php 
    include("database.php");
    $found = null;
?>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username= filter_input(INPUT_POST,"username",
                                FILTER_SANITIZE_SPECIAL_CHARS);
        $password= filter_input(INPUT_POST,"password",
                                FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username) || empty($password)){
            echo "Please enter all the required";
            echo "<script>alert('Didnt go in!');</script>";
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
                    echo "<script>alert('Youre logged in!');</script>";
                    header("Location: homepage.php");
                }else{
                    echo "<script>alert('Wrong password!');</script>";
                }


                
            
            $stmt->closeCursor();
            }catch (PDOException $e) {
                echo "Error: Returning users" . $e->getMessage();
            }
        }
    }
    
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