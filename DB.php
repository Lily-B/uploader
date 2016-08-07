<?php

class DB
{
    private $connect;

    function __construct($settings)
    {
        $this->connect = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['db'], $settings['user'], $settings['pass']);

    }

    public function newFile($fileName)
    {
        $stmt = $this->connect->prepare("INSERT INTO files (date, filename ) VALUES (:date,:name) ");
        $stmt->bindParam(':name', $fileName, PDO::PARAM_STR);
        $date = time();
        $stmt->bindParam(':date', $date, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteFile($fileId)
    {
        $stmt = $this->connect->prepare("DELETE FROM files WHERE id = :fileId ");
        $stmt->bindParam(':fileId', $fileId, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public function getFileName($fileId)
    {
        $stmt = $this->connect->prepare("SELECT filename FROM files WHERE id = :fileId ");
        $stmt->bindParam(':fileId', $fileId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $file = $stmt->fetch();
        return $file['filename'];

    }

    public function getFiles()
    {
        $stmt = $this->connect->query("SELECT * FROM files");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}