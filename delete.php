<?php

error_reporting(0);
require_once("files.php");
require_once("DB.php");
require_once("settings.php");
if (isset($_GET['fileId'])) {
    $files = new Files($settings);
    if ($files->removeFile($_GET['fileId'])) {
        $json['success'] = true;
        $json['result'] = "File deleted";
    } else {
        $json['success'] = false;
        $json['error'] = "File not found, or remove error";
    }
} else {
    $json['success'] = false;
    $json['error'] = "Parameters are not received";
}

echo json_encode($json);