<?php
// Connection with MySQL database
$conn = mysqli_connect('localhost', 'root', '', 'users_comments_database');

if (!$conn) {
    die("Connection Failed: ".mysqli_connect_error());
}