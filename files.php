<?php

class Files
{
    private $DB;
    private $blackList;
    private $dir;
    public $error;

    function __construct($settings)
    {
        $this->DB = new DB($settings);
        $this->blackList = $settings['blackList'];
        $this->dir = $settings['uploadDir'];

    }

    private function checkBlackList($filename)
    {
        $current_file_type = substr(strrchr($filename, '.'), 1);

        if (!in_array(substr(strrchr($filename, '.'), 1), $this->blackList)) {
            return false;
        }
        return true;
    }


    public function uploadFile($file)
    {
        if ($this->checkBlackList($file['name'])) {
            if (move_uploaded_file($file['tmp_name'], $this->dir . $file['name'])) {
                $this->DB->newFile($file['name']);
                return true;
            }
        } else {
            $this->error = "Banned file format.";
            return false;
        }
    }

    public function removeFile($fileId)
    {
        $fileName = $this->DB->getFileName($fileId);
        $path = $this->dir . $fileName;
        if (is_file($path) and unlink($path)) {
            $this->DB->deleteFile($fileId);
            return true;
        } else {
            return false;
        }
    }

    public function getFileArray()
    {
        return $this->DB->getFiles();
    }
}