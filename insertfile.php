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
        <title>Insert File</title>
        <link href="css/style.css" media="all" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <?php
            // If not logged in, the user will be redirected to the Login page
            if(isset($_SESSION['uid'])) {
                $id = $_SESSION['uid'];
                $lessons = array(0, 0, 0, 0);
                $sql = "SELECT * FROM classes WHERE professorid = '$id'";
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
        
        // Form to insert file to one of the subjects the professor teaches
        echo "<div class='container'>
            <form method='POST' action='inc/upload.inc.php' enctype='multipart/form-data'>
                
                <h1 class='title'>Select Subject</h1>
                <select name='subject' id='subject'>";
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row['classname']."'>'".$row['classname']."'</option>";
                    }
                echo "</select>";
                ?>
                <h1 class='title'>Select File</h1>
                <input  type='file' name='uploadFile'>
                <button class='btn' type='submit' name='inputFileSubmit'>Insert File</button>
            </form>
        </div>
    </body>
</html>