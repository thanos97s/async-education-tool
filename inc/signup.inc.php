<?php
include 'dbh.inc.php';

    if(isset($_POST['signupSubmit'])) {
        $userid = $_POST['userid'];
        $fullname = $_POST['fullname'];
        $pwd = $_POST['pwd'];
        $pwdConfirm = $_POST['pwdConfirm'];
        $profPwd = $_POST['profPwd'];

        require_once 'functions.inc.php';

        if(emptyInput($userid, $fullname, $pwd, $pwdConfirm) == true) {
            header("Location: ../signup.php?error=emptyinput");
            exit();
        }
        
        if(usedUid($conn, $userid) == true) {
            header("Location: ../signup.php?error=useduid");
            exit();
        }

        if(pwdCnfrm($pwd, $pwdConfirm) == false) {
            header("Location: ../signup.php?error=passwordcnfrm");
            exit();
        }

        if($profPwd == "123456") {
            $isProfessor = 1;
        }

        if(empty($profPwd)) {
            $isProfessor = 0;
        }
        
        if($profPwd != "123456") {
            header("Location: ../signup.php?error=profcnfrm");
            exit();
        }

        $sql = "INSERT INTO users (userid, fullname, pwd, isprofessor) VALUES ('$userid', '$fullname', '$pwd', '$isProfessor')";
        $conn->query($sql);

        header("Location: ../index.php");
    }

    else {
        header("Location: ../index.php");
        exit();
    }