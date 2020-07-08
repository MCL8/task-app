<?php

namespace app\models;

use components\Model;

class User extends Model
{
    protected $table = 'users';

    public $rules = [
        'required' => [
            ['login'],
            ['password']
        ]
    ];

    public function login()
    {
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;

        if ($login && $password) {
            $user = $this->findOne($login, 'login');

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    foreach ($user as $key => $value) {
                        if ($key != 'password') $_SESSION['user'][$key] = $value;
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public static function isAdmin()
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1);
    }
}
