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

            // Form to create a new subject
            echo "<div class='container'>";
                echo "<form method='POST' action='".createClass($conn)."'>
                    <h1 class='title'>Create Class</h1>
                    <input type='hidden' name='profid' value='".$id."'>
                    <div class='form-group'>
                        <label>Enter the name of the class:</label>
                        <input type='text' class='form-control' name='classname' placeholder='Class Name'><br>
                    </div>
                    <button class='btn' type='submit' name='createClass'>Create class</button>";

            echo "</div>";

            ?>
    </body>
</html>