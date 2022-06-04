<?php

if(isset($_POST["submit"])){
    $username = $_POST['uid'];
    $pwd = $_POST['pwd'];
    
    require_once "dbh.inc.php"; // يجب أن تكون متصل بقاعده البيانات للتأكد من وجود المستخدم
    require_once "functions.inc.php"; // هذه صفحه العمليات التى تستدعيها هنا

    // == true || !== false
    if (emptyInputLogin($username, $pwd) == true){
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $pwd); // قم بإدخل المستخدم إلى نجى من الشرط السابق ولم يتم توجيه إلى صفحة أوخرى



} else { // إذا فشل في تجاوز الشرط الكبير في هذه الصفحة
    header("location: ../login.php");
    exit();
}