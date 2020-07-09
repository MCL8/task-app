<?php

namespace app\models;

use components\Model;
use PDO;

class Task extends Model
{
    public $table = 'tasks';

    public $rules = [
        'required' => [
            ['user_name'],
            ['email'],
            ['text'],
        ],
        'email' => [
            ['email']
        ],
    ];

    /**
     * @param string $user_name
     * @param string $email
     * @param string $text
     * @return bool
     */
    public function create(string $user_name, string $email, string $text)
    {
        $user_name = trim($user_name);
        $user_name = htmlspecialchars($user_name);
        $email = htmlspecialchars($email);
        $text = htmlspecialchars($text);

        $sql = "INSERT INTO {$this->table} (user_name, email, text) " .
            'VALUES (:user_name, :email, :text)';


        $queryResult = $this->pdo->prepare($sql);
        $queryResult->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $queryResult->bindParam(':email', $email, PDO::PARAM_STR);
        $queryResult->bindParam(':text', $text, PDO::PARAM_STR);

        $result = $queryResult->execute();

        if ($result) {
            $_SESSION['success'] = 'Задача добавлена!';
        }

        return $result;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        $data['text'] = htmlspecialchars($data['text']);

        $sql = "UPDATE {$this->table} " .
            'SET text = :text, status = :status, modified = :modified ' .
            'WHERE id = :id';

        $queryResult = $this->pdo->prepare($sql);
        $queryResult->bindParam(':id', $id, PDO::PARAM_STR);
        $queryResult->bindParam(':text', $data['text'], PDO::PARAM_STR);
        $queryResult->bindParam(':status', $data['status'], PDO::PARAM_STR);
        $queryResult->bindParam(':modified', $data['modified'], PDO::PARAM_INT);

        return $queryResult->execute();
    }
}