<?php

class DB
{
    /**@var \PDO**/
    private static $instance;
    private $pdo;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function connect()
    {
        $host = DB_HOST;
        $dbname = DB_NAME;
        $userName = DB_USER;
        $password = DB_PASSWORD;

        if (!$this->pdo) {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $userName, $password);
        }

        return $this->pdo;
    }

    public function exec($query, $params = [])
    {
        $this->connect();
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);

        if (!$ret) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            }

            return false;
        }

        return $query->rowCount();
    }

    public function fetchAll($query, $params = [])
    {
        $this->connect();
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);

        if (!$ret) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            }

            return false;
        }

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    public function fetchOne($query, $params = [])
    {
        $this->connect();
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);

        if (!$ret) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            }

            return false;
        }

        $result = $query->fetchAll($this->pdo::FETCH_ASSOC);

        return reset($result);
    }

    public function lastInsertId()
    {
        $this->connect();
        return $this->pdo->lastInsertId();
    }
}
