<?php

namespace App\Config;
use PDO;


class Database
{

    private $pdo;

    private $stmt;

    public function __construct()
    {
//        echo "-----------------At Database.php <br />";

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options = array (
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->pdo = new PDO ($dsn, DB_USER, DB_PASS, $options);
        }
        catch ( \PDOException $e ) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function query($query) {
        if (isset($this->pdo)) {
        } else {
        }
        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->execute();
    }

    public function fetchList(){
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

}