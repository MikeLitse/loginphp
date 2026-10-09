<?php 
    include("database.php");
?>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = strtolower($_POST["password"]); //all the passwords to lowercase
        $email = $_POST["email"];

        if(empty($username) || empty($password) || empty($email)){
            echo "<script>alert('Please fill all that is required!');</script>";
        }else{
            try{
                $pdo = new PDO($dsn, $db_user, $db_pass, $options);

                $stmt = $pdo->prepare("CALL get_user_by_name(:username)");

                $stmt->execute([
                    "username"=> $username,
                ]);

                $rows = $stmt->fetchAll();

                $stmt->closeCursor(); //stops db searching

                //check if the username exists in the rows
                //if it exists -> username already in use
                if(empty($rows)){
                    //hash the password
                    $hash=password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $pdo->prepare("CALL insert_user(:username,:password,:email)");

                    $stmt->execute([
                        "username"=> $username,
                        "password"=> $hash,
                        "email"=> $email
                    ]);

                    $stmt->closeCursor(); //stops database searching

                    
                    session_start();
                    //variables for session
                    $_SESSION["msg"]=$regmsg;
                    $_SESSION["username"] = $username;
                    $_SESSION["password"] = $password;
                    //head to session
                    header("Location: homepage.php");

                    exit;

                }else{
                    echo "<script>alert('This username already exists')</script>";
                }

            }catch(PDOException $e){
                if(isset($e->errorInfo[1]) && $e->errorInfo[1]=== 1062){
                    if(str_contains($e->getMessage(),"email")){
                        $error_msg= "This email address is already registered";
                        echo "<script>alert('This email address already exists')</script>";
                    }else{
                        $error_msg= "This username is already registered";
                        echo "<script>alert('This username already exists')</script>";
                    }
                }else{
                    $error_msg= "db error";

                    error_log($e->getMessage()); //Logs error
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="header">
        <h1>Register</h1>
        <div>
            <h2>Username:</h2>
            <input type="text" name="username">
        </div>
        <div>
            <h2>Password:</h2>
            <input type="password" name="password">
        </div>
        <div>
            <h2>Email:</h2>
            <input type="email" name="email">
        </div>
        <div>
            <input type="submit" value="Register" name="submit" class="btn">
        </div>
        
        <h3>Already have an account? Login here:</h3>
        <a href="index.php">Login</a>
    </form>
</body>
</html>