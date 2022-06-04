<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat){
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)){
        return true;
    } else {
        return false;
    }
}

function invalidUid($username){
    if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        return true;
    }else{
        return false;
    }
}

function invalidEmail($email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    } else {
        return false;
    }
}

function pwdMatch($pwd, $pwdRepeat){
    if($pwd !== $pwdRepeat){
        return true; 
    } else {
        return false;
    }
}

function uidExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn); // ابداء الماصورة initialize the prepared statement
    if(!mysqli_stmt_prepare($stmt, $sql)/* هل هناك خطاء في إعداد الماصورة */){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email); // ادخل المعلومات في الماصورة المنقحه
    mysqli_stmt_execute($stmt);// دعها تقوم بعملها

    $resultData = mysqli_stmt_get_result($stmt); // ضع المعلومات في هذا المتغير
    if ($row = mysqli_fetch_assoc($resultData)){ // قم بتحويل المعلومات بطريقة نستطيع التعامل معها في ال بي إيش بي
        return $row;
    } else {
        $result  = false;
        return $result;
    }

    mysqli_stmt_close($stmt); // أغلق الماصورة
}

function createUser($conn, $name, $email, $username, $pwd){

    $sql = "INSERT INTO users(usersName, usersEmail, usersUid, usersPwd) VALUES(?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn); // ابداء الماصورة initialize the prepared statement
    if(!mysqli_stmt_prepare($stmt, $sql)/* هل هناك خطاء في إعداد الماصورة */){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd); // ادخل المعلومات في الماصورة المنقحه
    mysqli_stmt_execute($stmt);// دعها تقوم بعملها
    mysqli_stmt_close($stmt); // أغلق الماصورة
    header("location: ../signup.php?error=none");
    exit();
}


//=====================================================================
// login page functions
//=====================================================================

function emptyInputLogin($username, $pwd){
    if(empty($username) || empty($pwd)){
        return true;
    } else {
        return false;
    }
}

function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false ){
        header("location: ../login.php?error=wronglogin");
        exit();
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    } else if ($checkPwd === true) { /////////////////////////////////////////////////////////////////////////////////////
        session_start(); // نقوم ببدء جلسه لتكون المعلومات محفوظه في كل صفحات الموقع
        $_SESSION["userid"] = $uidExists['usersId']; // لنأخذ الرقم التعريفي الذي لا يمبغي تغييره
        $_SESSION["useruid"] = $uidExists['usersUid']; // واسم المستخدم الذي في الموقع والذي يفترض أن يكون مختلف لكل المستخدمين
        header("location: ../index.php");
        exit();
    }

}