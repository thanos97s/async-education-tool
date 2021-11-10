<?php
    date_default_timezone_set('Europe/Athens');
    include 'inc/dbh.inc.php';
    include 'inc/login.inc.php';
    include 'inc/comments.inc.php';
    require 'vendor/autoload.php';
    session_start();
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">

    <title>File Viewer</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

    


<body>
    <?php
        // If not logged in, the user will be redirected to the Login page
        if(isset($_SESSION['uid'])) {
            $userid = $_SESSION['uid'];
            $sql = "SELECT fullname, isprofessor FROM users WHERE id='$userid'";
            $result = $conn->query($sql);
            
            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
                $fullname = $row['fullname'];
                $isprofessor = $row['isprofessor'];
            }
        }

        else {
            header("Location: index.php");
        }

        //Download file from MongoDB database
        $fileid = $_GET['fileid'];
        $size = $_GET['size'];
        $downloadid = new MongoDB\BSON\ObjectID($fileid);

        $client = new MongoDB\Client;
        $db = $client->mydatabase;

        $gridfs = $db->selectGridFSBucket();
        $stream = $gridfs->openDownloadStream($downloadid);

        $buffer = fread($stream, 1024);
        for ($x = 1; $x < $size / 1024; $x++) {
            $buffer .= fread($stream, 1024);
        }

        $buffer .= fread($stream, $size % 1024);
        fclose($stream);
        $buffer2 = base64_encode($buffer);

        // Navigation bar: Redirect to Home or Logout
        echo "<center>";
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

        // File display 
        echo "<iframe src='data:application/pdf;base64,".$buffer2."' style='position: relative; top: 150px;' width='900px' height='1400px'></iframe>";
        
        echo "<br><br><br><br><br><br><br><br><br><br>";

        // Comment box
        echo "<div class='comment-box'>";
        echo "<form method='POST' action='".setComments($conn)."'>
                
            <input type='hidden' name='userid' value='".$userid."'>
            <input type='hidden' name='fullname' value='".$fullname."'>
            <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
            <input type='hidden' name='fileid' value='".$fileid."'>
                
            <div class='form-group'>
                <label>Quoting page:</label>
                <input type='number' class='form-control' id='pagenum' name ='page' placeholder='Page number:' required>
                <label>Quoting row:</label>
                <input type='number' class='form-control' id='rownum' name ='row' placeholder='Row number:' required><br>
            </div>
            <label>Your Comment:</label><br>
            <textarea name='message' id='comment' placeholder='Enter your comment here' required></textarea>

            <div class='form-group'>
                <button type='submit' class='btn' name='commentSubmit'>Comment</button>
            </div>
        </form>
        <div class='prev-comments'>";
        
        // Function to retrieve comments
        getComments($conn, $fileid, $isprofessor);
        echo"</div>";
        echo "</center>";
    ?>
</body>
</html>