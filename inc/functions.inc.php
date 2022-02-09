<?php

// Check if any of the inputs in the Signup page is empty
function emptyInput($userid, $fullname, $pwd, $pwdConfirm) {
    if(empty($userid) || empty($fullname) || empty($pwd) || empty($pwdConfirm)) {
        $result = true;
    }

    else {
        $result= false;
    }

    return $result;
}

// Check if the username chosen is already used
function usedUid($conn, $userid) {
    $sql ="SELECT * FROM users WHERE userid = '$userid'";
    $sqlresult = $conn->query($sql);
    if(mysqli_num_rows($sqlresult) >= 1) {
        $result = true;
    }

    else {
        $result = false;
    }

    return $result;
}

// Check if the password matches the confirmation
function pwdCnfrm($pwd, $pwdConfirm) {
    if($pwd == $pwdConfirm) {
        $result = true;
    }

    else {
        $result = false;
    }

    return $result;
}