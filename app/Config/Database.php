<?php

namespace App\Config;
use PDO;


class Database
{

    private $pdo;

    private $stmt;

    public function __construct()
    {
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

    public function excute($query, $params=[]) {
        try {

            if (isset($this->pdo)) {
            }
            $this->stmt = $this->pdo->prepare($query);

            $excuteResult = $this->stmt->execute($params);
            return ['res' => $excuteResult, 'succeeded' => true];
        } catch (\Exception $e) {
            return ['info' => $e->getMessage(), 'succeeded' => false];

        }

    }

    public function fetchList(){
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetch(){
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }

}