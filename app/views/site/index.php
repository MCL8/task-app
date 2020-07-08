<!DOCTYPE html>
<html lang="en">

<?php include ROOT . '/app/views/layouts/header.php'; ?>

<body>
    <div class="container">
        <br>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?=$_SESSION['success']; unset($_SESSION['success'])?>
            </div>
        <?php endif; ?>

        <?php if ($admin): ?>
            <a href="/user/logout">Выйти из профиля админа</a>
        <?php else: ?>
            <a href="/user/login">Вход для администратора</a>
        <?php endif; ?>

        <p>Сортировка</p>
        <select id="sort" class="custom-select" onchange="sort(this)">
            <option value="user_name">Имя пользователя по возрастанию</option>
            <option value="user_name_desc" <?=$orderBy == 'user_name_desc' ? 'selected' : ''?>>Имя пользователя по убыванию</option>
            <option value="email" <?=$orderBy == 'email' ? 'selected' : ''?>>Email по возрастанию</option>
            <option value="email_desc" <?=$orderBy == 'email_desc' ? 'selected' : ''?>>Email по убыванию</option>
            <option value="status" <?=$orderBy == 'status' ? 'selected' : ''?>>Статус по возрастанию</option>
            <option value="status_desc" <?=$orderBy == 'status_desc' ? 'selected' : ''?>>Статус по убыванию</option>
        </select>
        <br><br>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Имя пользователя</th>
                    <th scope="col">Email</th>
                    <th scope="col">Текст задачи</th>
                    <th scope="col">Статус</th>
                    <?php if ($admin): ?>
                        <th scope="col"></th>
                    <? endif; ?>
                    <th scope="col">Изменена админом</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($taskList as $task): ?>
                    <tr>
                        <td><?=$task['user_name']?></td>
                        <td><?=$task['email']?></td>
                        <td><?=$task['text']?></td>
                        <td><?=$task['status']?></td>
                        <?php if ($admin): ?>
                            <td><a href="/task/update/<?=$task['id']?>"><?php include ROOT . '/app/views/layouts/pencil.svg'; ?></a></td>
                        <? endif; ?>
                        <td class="text-center"><?=$task['modified'] == 1 ? '&#10004;' : ''?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($pagination->countPages > 1): ?>
            <?=$pagination?>
        <?php endif; ?>

        <a href="/task/create" class="btn btn-primary">Создать задачу</a>

    </div>
    <script src="/js/app.js"></script>
</body>
</html>

