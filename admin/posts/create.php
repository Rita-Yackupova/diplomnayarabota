<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}

include "../menu.php";

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление должности</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="login-page-create">
        <div class="form">
            <form action="../php/posts/create.php" method="post" class="login-form">
                <p>Название должности</p>
                <input required type="text" name="title">
                <br><br>
                <button type="submit">Добавить должность</button>
            </form>
        </div>
    </div>
</body>

</html>