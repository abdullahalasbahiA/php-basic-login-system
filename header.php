<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header>
        <?php
            if(isset($_SESSION['useruid'])){
                echo"
                <a href='profile.php'>profile page</a>
                <a href='includes/logout.inc.php'>logout</a>";
            } else {
                echo "<a href='signup.php'>signup</a>
                      <a href='login.php'>login</a>";
            }
        ?>
    </header>