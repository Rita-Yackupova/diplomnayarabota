<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id = $_GET['id'];

$admins = mysqli_query($connect, "SELECT * FROM `admins` WHERE `admins`.`id`='$id'") or die(mysqli_error($connect));
$admins = mysqli_fetch_assoc($admins);

$roleupd = mysqli_query($connect, "SELECT * FROM `roles` WHERE `roles`.`id`='$admins[id_role]' ") or die(mysqli_error($connect));
$roleupd = mysqli_fetch_assoc($roleupd);

$roles = mysqli_query($connect, "SELECT * FROM `roles`") or die(mysqli_error($connect));

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Изменение данных администратора</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="login-page-create">
        <div class="form">
            <form action="../php/admins/update.php?id=<?= $id ?>" method="post" class="login-form"
                enctype="multipart/form-data">

                <p>ФИО*</p>
                <input required type="text" name="name" value="<?= $admins['name'] ?>">

                <p>Должность*</p>
                <select required name="id_role">
                    <option selected value="<?= $roleupd['id'] ?>"><?= $roleupd['title'] ?> </option>
                    <?
                    foreach ($roles as $role) {
                        ?>
                        <option value="<?= $role['id'] ?>">
                            <?= $role['title'] ?>
                        </option>
                    <?
                    }
                    ?>
                </select>

                <p>Логин*</p>
                <input required type="text" name="login" value="<?= $admins['login'] ?>">
                <p>Пароль*</p>
                <input required type="text" name="password" value="<?= $admins['password'] ?>">
                <br><br>
                <button type="submit">Изменить данные администратора</button>
            </form>
        </div>
    </div>
</body>

</html>