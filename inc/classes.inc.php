<?php

// Enroll in class
function enrollClass($conn, $userid) {
    if (isset($_POST['addClass'])) {
        $classid = $_POST['classid'];
        $sql = "SELECT * FROM enrollment WHERE studentid = '$userid' AND classid = '$classid'";
        $result = $conn->query($sql);

        if(mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO enrollment (studentid, classid) VALUES ('$userid', '$classid')";
            $conn->query($sql);
        }
    }
}

// Remove class from student portofolio
function removeClass($conn) {
    if (isset($_POST['classRemove'])) {
        $classid = $_POST['classid'];
        $studentid = $_POST['studentid'];

        $sql = "DELETE FROM enrollment WHERE classid = '$classid' AND studentid = '$studentid'";
        $conn->query($sql);
    }
}

// Creation of a new class by professor
function createClass($conn) {
    if (isset($_POST['createClass'])) {
        $classname = $_POST['classname'];
        $profid = $_POST['profid'];

        $sql = "INSERT INTO classes (classname, professorid) VALUES ('$classname', '$profid')";
        $conn->query($sql);
    }
}