<?php

require '../vendor/autoload.php';

// Upload file to MongoDB database
if (isset($_POST['inputFileSubmit'])) {
    $file = $_FILES["uploadFile"];
    
    $lesson = $_POST["subject"];
    $fileName = $_FILES["uploadFile"]["name"];
    $fileTmpName = $_FILES["uploadFile"]["tmp_name"];
    $fileSize = $_FILES["uploadFile"]["size"];
    $fileError=  $_FILES["uploadFile"]["error"];

    if ($fileSize == 0) {
        echo "File error";
    }

    $options = [
        'metadata' => ['lesson'=>$lesson],
    ];

    $client = new MongoDB\Client;
    $db = $client->mydatabase;
    $gridfs = $db->selectGridFSBucket();
    $stream = $gridfs->openUploadStream($fileName, $options);
    $contents = file_get_contents($fileTmpName);
    fwrite($stream, $contents);
    fclose($stream);
    header("Location: ../insertfile.php");
}
 