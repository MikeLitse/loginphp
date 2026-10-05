<?php

    session_start();

    echo "Username: " . $_SESSION['username'] . "<br>";
    echo "Password: " . $_SESSION['password'] . "<br>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form>
        <h>Hello this is the home page</h>
    </form>
    <a href="index.php">Logout</a>
</body>
</html>