<?php
// Login User
function getLogin($conn) {
    if (isset($_POST['loginSubmit'])) {
        $userid = $_POST['userid'];
        $pwd = $_POST['pwd'];
        $sql = "SELECT * FROM users WHERE userid='$userid' AND pwd='$pwd'";
        $result = $conn->query($sql);
        if (mysqli_num_rows($result) == 1) {
            if ($row = $result->fetch_assoc()) {
                session_start();
                $_SESSION['uid'] = $row['id'];
                header("Location: home.php");
            }
        }

        else {
            header("Location: index.php?error=loginfailed");
        } 
    }
}
// Logout User
function userLogout() {
    if (isset($_POST['logoutSubmit'])) {
        session_start();
        session_destroy();
        header("Location: index.php");
    }
}