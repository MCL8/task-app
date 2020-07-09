<?php

namespace app\controllers;

use app\models\User;
use components\Controller;
use components\Pagination;
use app\models\Task;

class SiteController extends Controller
{
    /**
     * @return bool
     */
    public function actionIndex()
    {
        $orderBy = 'user_name';
        $orderBySql = 'user_name';

        $orderList = [
            'user_name' => 'user_name',
            'user_name_desc' => 'user_name DESC',
            'email' => 'email',
            'email_desc' => 'email DESC',
            'status' => 'status',
            'status_desc' => 'status DESC',
        ];

        if (isset($_GET['sort']) && isset($orderList[$_GET['sort']])) {
            $orderBy = $_GET['sort'];
            $orderBySql = $orderList[$_GET['sort']];
        }

        $task = new Task();

        $total = $task->count();
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 3;

        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $taskList = $task->findAll($start, $perpage, $orderBySql);

        $admin = User::isAdmin();

        $this->loadView('/site/index', compact('taskList', 'orderBy', 'pagination', 'admin'));

        return true;
    }

    /**
     * @return bool
     */
    public function actionCreate()
    {
        $this->loadView('/site/create');

        return true;
    }

    /**
     * @return bool
     */
    public function actionStore()
    {
        $task = new Task();
        $data = [];

        if (!empty($_POST)) {
            $data['user_name'] = $_POST['user_name'];
            $data['email'] = $_POST['email'];
            $data['text'] = $_POST['text'];
        }

        if (!$task->validate($data)) {
            $task->getErrors();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/task/create');

            return true;
        }

        $task->create($data['user_name'], $data['email'], $data['text']);

        header('Location: http://' . $_SERVER['HTTP_HOST']);

        return true;
    }

    public function actionUpdate($id)
    {
        $task = new Task();

        if (!User::isAdmin()) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/user/login');
            return true;
        }

        if (!empty($_POST)) {
            $status = isset($_POST['completed']) ? 'Выполнена' : 'Новая';
            $task->update($id, ['text' => $_POST['text'], 'status' => $status, 'modified' => $_POST['modified']]);
            header('Location: http://' . $_SERVER['HTTP_HOST']);
        }

        $taskArr = $task->findOne($id, 'id');

        if (User::isAdmin()) {
            $this->loadView('/site/update', compact('taskArr'));
        } else {
            header('Location: http://' . $_SERVER['HTTP_HOST']);
        }

        return true;
    }
}
