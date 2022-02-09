<?php

// Create comment
function setComments($conn) {
    if (isset($_POST['commentSubmit'])) {
        $userid = $_POST['userid'];
        $fullname = $_POST['fullname'];
        $date = $_POST['date'];
        $fileid = $_POST['fileid'];
        $message = $_POST['message'];
        $page = $_POST['page'];
        $row = $_POST['row'];

        $sql = "INSERT INTO comments (userid, fullname, date, fileid, page, row, message) VALUES ('$userid','$fullname', '$date', '$fileid', '$page', '$row', '$message')";
        $conn->query($sql);
    }  
}

// Get list of comments for a file
function getComments($conn, $fileid, $link, $isprofessor) {
    $sql = "SELECT * FROM comments WHERE fileid='$fileid'";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        echo "<div class='single-item'><p>";
            echo $row['fullname']."<br>";
            echo $row['date']."<br>";
            echo "Quoting Page: ";
            echo $row['page'];
            echo " Row: ";
            echo $row['row']."<br><br>";
            echo "<b>".nl2br($row['message'])."</b>";
        echo "</p>";
        if ($row['userid'] == $_SESSION['uid'] || $isprofessor == 1) {
            echo "<form method='POST' action='".deleteComments($conn)."'>
                <input type='hidden' name='commentid' value='".$row['commentid']."'> 
                <button type='submit' class='btn' name='commentDelete'>Delete</button>
            </form>";
        }

        if ($row['userid'] == $_SESSION['uid']) {
            echo "<form method='POST' action='editcomment.php'>
                <input type='hidden' name='commentid' value='".$row['commentid']."'>
                <input type='hidden' name='message' value='".$row['message']."'>
                <input type='hidden' name='fileviewerlink' value='".$link."'> 
                <button class='btn'>Edit</button>
            </form>";
        }
        echo "</div>";

    }   
}

// Edit comment
function editComments($conn) {
    if (isset($_POST['commentEdit'])) {
        $commentid = $_POST['commentid'];
        $message = $_POST['message'];
        $link = $_POST['link'];
        
        $sql = "UPDATE comments SET message='$message' WHERE commentid='$commentid' ";
        $conn->query($sql);
        header("Location: $link");
    }  
}

// Delete comment
function deleteComments($conn) {
    if (isset($_POST['commentDelete'])) {
        $commentid = $_POST['commentid'];

        $sql = "DELETE FROM comments WHERE commentid='$commentid' ";
        $conn->query($sql);
    }
}