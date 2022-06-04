<?php

if (isset($_POST["submit"])) {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // == true || !== false
    if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) == true){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username) == true){
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) == true){
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) == true){
        header("location: ../signup.php?error=passworddontmatch");
        exit();
    }
    if (uidExists($conn, $username, $email) == true){
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd);

} else {
    header("location: ../signup.php");
    exit();
}