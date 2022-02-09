<?php
    date_default_timezone_set('Europe/Athens');
    include 'inc/dbh.inc.php';
    include 'inc/comments.inc.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Comment</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<?php
    $commentid = $_POST['commentid'];
    $message = $_POST['message'];
    $link = $_POST['fileviewerlink'];

    // Edit Comments
    echo "<div class ='container'>
        <form method='POST' action='".editComments($conn)."'>
            <input type='hidden' name='commentid' value='".$commentid."'>
            <div class='form-group'>
                <label>Edit your Comment:</label>
            </div>
            <textarea name='message' id='comment'>".$message."</textarea><br>
            <input type='hidden' name='link' value='".$link."'>
            
            <button type='submit' class ='btn' name='commentEdit'>Edit</button>
        </form>
    </div>";
?>

</body>
</html>
