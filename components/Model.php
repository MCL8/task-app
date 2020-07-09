<?php

namespace components;
use Valitron\Validator;

abstract class Model
{
    protected $pdo;
    protected $table;
    protected $primaryKey = 'id';
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
     * @return bool
     */
    public function validate($data): bool
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


    public function getErrors(): void
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
    public function query(string $sql): bool
    {
        return $this->pdo->execute($sql);
    }

    /**
     * @param string $orderBy
     * @return array
     */
    public function findAll($start, $perpage, $orderBy = 'id'): array
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
     * @param string|null $field
     * @return mixed|null
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

}
