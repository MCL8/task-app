<!DOCTYPE html>
<html lang="en">

<?php include ROOT . '/app/views/layouts/header.php'; ?>

<body>
<div class="container">
    <br>
    <p><b>Имя пользователя:</b> <?=$taskArr['user_name']?></p>
    <p><b>Email:</b> <?=$taskArr['email']?></p>
    <form method="post">
        <div class="form-group">
            <label for="text">Текст задачи:</label>
            <textarea class="form-control" id="text" name="text" rows="5" onchange="setTextModified()"><?=trim($taskArr['text'])?></textarea>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="completed" name="completed" <?=$taskArr['status'] == 'Выполнена' ? 'checked' : ''?>>
            <label class="form-check-label" for="completed">Выполнена</label>
        </div>
        <input type="hidden" id="modified" name="modified" value="<?=$taskArr['modified']?>">
        <br>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="/" class="btn btn-primary ml-2">Назад</a>
    </form>
</div>
<script>
    function setTextModified() {
        let modified = document.getElementById('modified');
        modified.value = '1';
    }
</script>
</body>
</html>

