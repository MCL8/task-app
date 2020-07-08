<?php

namespace components;
use Valitron\Validator;

abstract class Model
{
    protected $pdo;
    protected $table;
    protected $primaryKey = 'id';
    public $attributes = [];
    public $errors = [];
    public $rules = [];

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->pdo = DB::getInstance();
    }

    /**
     * @param $data
     */
    public function load($data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);

        if ($v->validate()) {
            return true;
        }
        $this->errors = $v->errors();

        return false;
    }

    public function save($table)
    {
        $tbl = \R::dispense($table);

        foreach ($this->attributes as $name => $value) {
            $tbl->$name = $value;
        }
        return \R::store($tbl);
    }

    public function getErrors()
    {
        $errors = '<ul>';

        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
    }

    /**
     * @param string $sql
     * @return bool
     */
    public function query(string $sql)
    {
        return $this->pdo->execute($sql);
    }

    /**
     * @param string $orderBy
     * @return array
     */
    public function findAll($start, $perpage, $orderBy = 'id')
    {
        $sql = "SELECT * FROM `{$this->table}` ORDER BY {$orderBy} LIMIT {$start}, {$perpage}";

        return $this->pdo->query($sql);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";

        return $this->pdo->query($sql)[0]['total'];
    }

    /**
     * @param $id
     * @param string $field
     * @return array
     */
    public function findOne($id, ?string $field = '')
    {
        $field = $field ?: $this->primaryKey;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";

        $result = $this->pdo->query($sql, [$id]);

        if (!empty($result)) {
            return $result[0];
        }
        return null;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function findBySql(string $sql, ?array $params = [])
    {
        return $this->pdo->query($sql, $params);
    }

    /**
     * @param string $pattern
     * @param string $field
     * @param string $table
     * @return array
     */
    public function findLike(string $pattern, string $field, ?string $table = '')
    {
        $table = $table ?: $this->table;
        $sql = "SELECT * FROM $table WHERE $field LIKE ?";

        return $this->pdo->query($sql, ['%' . $pattern . '%']);
    }
}