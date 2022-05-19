<?php
class Dbh {
    private $host = "localhost";
    private $user = "property_management";
    private $pwd = "pXf@-2Sw";
    private $dbName = "property_management";

    protected function connect(){
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName;
        $pdo = new PDO($dsn, $this->user, $this->pwd);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}