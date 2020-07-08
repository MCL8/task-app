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

    <form method="post">
        <div class="form-group">
            <label for="login">Имя пользователя</label>
            <input type="text" class="form-control" id="login" name="login" placeholder="Введите имя пользователя">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
        <a href="/" class="btn btn-primary ml-2">Назад</a>
    </form>


</div>
<script src="/js/app.js"></script>
</body>
</html>

