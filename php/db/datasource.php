<?php

namespace db;

use PDO;

// 学習用：Datasourceクラスを使う際に、transactionをしたい時に、複数のdbインスタンスを作成することがあり、独立したdbが複数あっては良くない。
// そこで、dbをインスタンス化する際に、一度インスタンス化されているのかを確認するクラスを↓に定義！！
// この概念は、シングルトンと呼ばれ、プログラミング界では有名な概念らしいので、覚えておいて！！！！
class PDOSingleton
{
    private $conn;

    private static $singleton;

    private function __construct($dsn, $username, $password)
    {
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public static function getInstance($dsn, $username, $password)
    {
        if (!isset(self::$singleton)) {
            $instance = new PDOSingleton($dsn, $username, $password);
            self::$singleton = $instance->conn;
        }
        return self::$singleton;
    }
}

class DataSource
{

    private $conn;
    private $sqlResult;
    public const CLS = 'cls';

    public function __construct($host = 'localhost', $port = '3306', $dbName = 'pollapp', $username = 'test_user', $password = 'pwd')
    {

        $dsn = "mysql:host={$host};port={$port};dbname={$dbName};";
        $this->conn = PDOSingleton::getInstance($dsn, $username, $password);
    }

    public function select($sql = "", $params = [], $type = '', $cls = '')
    {
        $stmt = $this->executeSql($sql, $params);
        if ($type === static::CLS) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, $cls);
        } else {
            return $stmt->fetchAll();
        }
    }

    public function execute($sql = "", $params = [])
    {
        $this->executeSql($sql, $params);
        return  $this->sqlResult;
    }

    public function selectOne($sql = "", $params = [], $type = '', $cls = '')
    {
        $result = $this->select($sql, $params, $type, $cls);
        return count($result) > 0 ? $result[0] : false;
    }

    public function begin()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollback()
    {
        $this->conn->rollback();
    }

    private function executeSql($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        $this->sqlResult = $stmt->execute($params);
        return $stmt;
    }
}
