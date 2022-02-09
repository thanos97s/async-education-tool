<?php
require '../vendor/autoload.php';

// Delete file from MongoDB database
if (isset($_POST['mongoDeleteSubmit'])) {

    $fileid = $_POST['fileid'];
    $deleteid = new MongoDB\BSON\ObjectID($fileid);

    $client = new MongoDB\Client;
    $db = $client->mydatabase;
    $gridfs = $db->selectGridFSBucket();
    $gridfs->delete($deleteid);

    header("Location: ../home.php");
}