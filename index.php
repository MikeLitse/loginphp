<?php 
    include("database.php");
?>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username= filter_input(INPUT_POST,"username",
                                FILTER_SANITIZE_SPECIAL_CHARS);
        $password= filter_input(INPUT_POST,"password",
                                FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username) || empty($password)){
            echo "<script>alert('Please enter all the required!');</script>";
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
                }else{
                    if(password_verify($password, $rows["0"]["pass"])){

                        session_start();
                        //variables for session
                        $_SESSION["msg"]=$logmsg;
                        $_SESSION["username"] = $username;
                        $_SESSION["password"] = $password;
                        //head to session
                        header("Location: homepage.php");

                        exit;

                    }else{
                        echo "<script>alert('Wrong password!');</script>";
                    }
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
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="header">
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
            <input type="submit" value="LOGIN" name="submit" class="btn">
        </div>
        
        <h3>Dont have an account? Register here:</h3>
        <a href="register.php">Register</a>
    </form>
</body>
</html>