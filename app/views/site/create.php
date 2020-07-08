<!DOCTYPE html>
<html lang="en">

<?php include ROOT . '/app/views/layouts/header.php'; ?>

<body>
<div class="container">
    <br>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?=$_SESSION['errors']; unset($_SESSION['errors'])?>
        </div>
    <?php endif; ?>

    <form action="/task/store" method="post">
        <div class="form-group">
            <label for="user_name">Имя</label>
            <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Введите имя">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Введите email">
        </div>
        <div class="form-group">
            <label for="email">Текст задачи</label>
            <textarea class="form-control" name="text" id="text" rows="5"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Создать</button>
        <a href="/" class="btn btn-primary ml-2">Назад</a>
    </form>

</div>
<script src="/js/app.js"></script>
</body>
</html>

