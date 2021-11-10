<?php
    date_default_timezone_set('Europe/Athens');
    include 'inc/dbh.inc.php';
    include 'inc/login.inc.php';
    include 'inc/classes.inc.php';
    require 'vendor/autoload.php';
    session_start();
    $client = new MongoDB\Client;
    $db = $client->mydatabase;               
?>

<html>

    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link href="css/style.css" media="all" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <?php
            // If not logged in, the user will be redirected to the Login page
            if(isset($_SESSION['uid'])) {
                $id = $_SESSION['uid'];
                
                $sql = "SELECT * FROM users WHERE id = '$id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                
                //Variable to check if user is professor or student
                $isprofessor = $row['isprofessor'];
            }

            else {
                header("Location: index.php");
            }

            echo "<nav>
            <ul>";
            // The professor can add files to classes, or create classes
            if ($isprofessor == 1) {
                echo"<li>";
                echo "<a href='insertfile.php'>Insert File</a>";
                echo"</li>";

                echo"<li>";
                echo "<a href='createclass.php'>Create Class</a>";
                echo"</li>";
            }
            
            // The student can select which classes to enroll
            else {
                echo"<li>";
                echo "<a href='selectclass.php'>Add Classes</a>";
                echo"</li>";
            }

            // Logout button
            echo"<li>";
            echo "<form method='POST' action='".userLogout($conn)."'>
            <button type='submit' class='button' name='logoutSubmit'>Logout</button>
            </form>";
            echo"</li>";
            echo "</ul>
            </nav>";

            // Create list of lessons that the professor teaches
            if($isprofessor == 1) {
                $sql = "SELECT * FROM classes WHERE professorid = '$id'";
                $result = $conn->query($sql);
                echo "<div class='container2'>";
                while($row = $result->fetch_assoc()) {

                    echo "<details>
                    <summary>".$row['classname']."</summary>
                    <div class='content'>";
                        
                        // Find files and assign them by the subject they are connected to
                        $options = [
                            'metadata' => ['lesson'=>$row['classname']],
                        ];

                        $gridfs = $db->selectGridFSBucket();
                        $find = $gridfs->find($options);
                        
                        // Display list of files
                        foreach ($find as $doc) {

                            $link = "file_viewer.php?fileid=";
                            $link .= $doc->_id;
                            $link .= "&size=";
                            $link .= $doc->length;

                            echo "<a href=".$link.">".$doc->filename."</a>";
                                
                                // The professor can delete files
                            echo "<form method='POST' action='mongodelete.inc.php'>
                                <input type='hidden' name='fileid' value='".$doc->_id."'>
                                <button type='submit' class='button' name='mongoDeleteSubmit'>X</button>
                            </form>";

                            echo "<br>";
                        }
                            
                    echo "</div>
                    </details>";
                    
                }
                
                echo "</div>";
            }

            // Create list of lessons that the student is enrolled to
            if($isprofessor == 0) {
                $sql = "SELECT * FROM enrollment WHERE studentid = '$id'";
                $result = $conn->query($sql);

                echo "<div class='container2'>";
                while($row = $result->fetch_assoc()) {
                    $classid = $row['classid'];
                    $sql = "SELECT * FROM classes WHERE classid = '$classid'";
                    $result2 = $conn->query($sql);
                    $row2 = $result2->fetch_assoc();

                    
                    echo "<details>
                    <summary>".$row2['classname']."</summary>
                    <div class='content'>";
                        
                        $options = [
                            'metadata' => ['lesson'=>$row2['classname']],
                        ];
                        
                        // Remove class
                        echo "<form method='POST' action='".removeClass($conn)."'>
                            <input type='hidden' name='studentid' value='".$id."'>
                            <input type='hidden' name='classid' value='".$row2['classid']."'> 
                            <button type='submit' class='button' name='classRemove'>Remove Class</button>
                        </form>";
                            
                        // Display list of files
                        $gridfs = $db->selectGridFSBucket();
                        $find = $gridfs->find($options);
                            
                        foreach ($find as $doc) {

                            $link = "file_viewer.php?fileid=";
                            $link .= $doc->_id;
                            $link .= "&size=";
                            $link .= $doc->length;

                            echo "<a href=".$link.">".$doc->filename."</a>";

                            echo "<br>";
                        }
                            
                    echo "</div>
                    </details>";
                        
                }
                echo "</div>";
            }
        ?>
    </body>
</html>