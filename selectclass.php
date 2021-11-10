<?php
    date_default_timezone_set('Europe/Athens');
    include 'inc/dbh.inc.php';
    include 'inc/login.inc.php';
    include 'inc/classes.inc.php';
    require 'vendor/autoload.php';
session_start();
?>

<!DOCTYPE = html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Select Class</title>
        <link href="css/style.css" media="all" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <?php

            // If not logged in, the user will be redirected to the Login page
            if(isset($_SESSION['uid'])) {
                $id = $_SESSION['uid'];
                $sql = "SELECT * FROM enrollment WHERE studentid = '$id'";
                $result = $conn->query($sql);
            }

            else {
                header("Location: index.php");
            }

            // Navigation bar: Redirect to Home or Logout
            echo "<nav>
                <ul>
                <li>
                    <a href='home.php'>Home</a>
                </li>
            
                <li>
                    <form method='POST' action='".userLogout($conn)."'>
                        <button type='submit' class='button' name='logoutSubmit'>Logout</button>
                    </form>
                </li>;
                </ul>
            </nav>";

            // Add classes
            echo "<div class='container'>";
            echo "<form method='POST' action='".enrollClass($conn, $_SESSION['uid'])."'>
                <h1 class='title'>Add Class</h1>
                <select name='classid' id='classid'>";
                    
                    $sql = "SELECT * FROM classes";
                    $result2 = $conn->query($sql);

                    $lessons = array();
                    $lessonnames = array();
                    while($row2 = $result2->fetch_assoc()) {
                        $lessons[] = $row2['classid'];
                        $lessonnames[] = $row2['classname'];
                    }

                    // Check which lessons the student is already enrolled to
                    while($row = $result->fetch_assoc()) {
                        $i = 0;
                        while($i < count($lessons)) {
                            if($lessons[$i] == $row['classid']) {
                                unset($lessons[$i]);
                                unset($lessonnames[$i]);
                                $lessons = array_values($lessons);
                                $lessonnames = array_values($lessonnames);
                                $i = 0;
                            }
                            $i++;
                        }
                    }

                    $i = 0;
                    while($i < count($lessons)) {
                        echo "<option value='".$lessons[$i]."'>".$lessonnames[$i]."</option>";
                        $i++;
                    }
                    
                echo "</select>
                <button class='btn' type='submit' name='addClass'>Enroll in class</button>
            </form>
            </div>";
        ?>
    </body>
        