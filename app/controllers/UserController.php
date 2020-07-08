<?php

namespace app\controllers;

use components\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionLogin()
    {
        if (!empty($_POST)) {
            $user = new User();

            if (!$user->validate(['login' => $_POST['login'], 'password' => $_POST['password']])) {
                $user->getErrors();
            } else {
                if ($user->login()) {
                    $_SESSION['success'] = 'Пользователь авторизован!';
                    header('Location: http://' . $_SERVER['HTTP_HOST']);
                } else {
                    $_SESSION['errors'] = 'Неверное имя или пароль';
                }
            }
        }

        $this->loadView('/user/login');

        return true;
    }

    public function actionLogout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        header('Location: http://' . $_SERVER['HTTP_HOST']);

        return true;
    }
}