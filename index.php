<?php
error_reporting(0);
require_once("files.php");
require_once("DB.php");
require_once("settings.php");

$ctrl = new Files($settings);

if ($_FILES['file']) {
    $ctrl->uploadFile($_FILES['file']);
}
$ctrl->getFileArray();
$files = $ctrl->getFileArray();
require_once("template.php");
