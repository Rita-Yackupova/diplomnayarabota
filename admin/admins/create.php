<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}

require_once '../php/connect.php';
include "../menu.php";

$roles = mysqli_query($connect, "SELECT * FROM `roles`") or die(mysqli_error($connect));

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление администратора</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="login-page-create">
        <div class="form">
            <form action="../php/admins/create.php" method="post" class="login-form">
                <p>ФИО</p>
                <input required type="text" name="name" placeholder="Введите ФИО">
                <p>Роль</p>
                <select name="id_role">
                    <option selected disabled>Выберите роль</option>
                    <?php
                    foreach ($roles as $role) {
                        ?>
                        <option value="<?= $role['id'] ?>">
                            <?= $role['title'] ?>
                        </option>
                    <?
                    }
                    ?>
                </select>
                <p>Логин</p>
                <input required type="text" name="login" placeholder="Введите логин"> 
                <p>Пароль</p>
                <input required type="password" name="password" placeholder="Введите пароль">
                <br><br>
                <button type="submit">Добавить администратора</button>
            </form>
        </div>
    </div>
</body>

</html>