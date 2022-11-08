<?php

namespace app\core\database;

use PDO;

final class Database
{
    private  ?\PDO $connection  = null;
    private static ?Database $db  = null;

    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function GetInstance()
    {
        if (is_null(self::$db)) {
            self::$db = new self;
        }
        return self::$db;
    }

    public function Connect(array $config)
    {
        if (is_null($this->connection)) {
            $this->connection = new PDO($config["dsn"], $config["user"], $config["password"]);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $this->connection;
    }

    public function Disconnect()
    {
        $this->connection = null;
    }
}
