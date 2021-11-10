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

    // Edit Comments
    echo "<form method='POST' action='".editComments($conn)."'>
        <input type='hidden' name='commentid' value='".$commentid."'>
        <textarea name='message'>".$message."</textarea><br>
        <button type='submit' name='commentEdit'>Edit</button>
    </form>";
?>

</body>
</html>
