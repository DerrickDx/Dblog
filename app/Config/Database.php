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

    public function query($query, $params=[]) {
        if (isset($this->pdo)) {
        } else {

        }
        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->execute($params);
    }

    public function fetchList(){
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetch(){
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function bindValue($param, $value, $type = null) {
        if (is_null ($type)) {
            switch (true) {
                case is_int ($value) :
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool ($value) :
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null ($value) :
                    $type = PDO::PARAM_NULL;
                    break;
                default :
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function bindParam($param, $var)
    {
        $this->stmt->bindParam($param, $var, PDO::PARAM_INT);
    }
}