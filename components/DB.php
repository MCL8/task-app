<?php

namespace components;

class DB
{
    protected static $instance;
    protected $pdo;
    public static $countSql = 0;
    public static $queries = [];

    /**
     * Db constructor.
     */
    protected function __construct()
    {
        $db = require ROOT . '/config/db_config.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];

        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }

    /**
     * @return DB
     */
    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function execute(string $sql, ?array $params = []): bool
    {
        self::$countSql++;
        self::$queries[] = $sql;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }


    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function query(string $sql, ?array $params = []): array
    {
        self::$countSql++;
        self::$queries[] = $sql;

        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);

        if ($res !== false) {
            return $stmt->fetchAll();
        }
        return [];
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}