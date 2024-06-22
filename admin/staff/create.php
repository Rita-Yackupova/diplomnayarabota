<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}

require_once '../php/connect.php';
include "../menu.php";

$posts = mysqli_query($connect, "SELECT * FROM `posts`") or die(mysqli_error($connect));

$med_rooms = mysqli_query($connect, "SELECT * FROM `med_room`") or die(mysqli_error($connect));

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление материала</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="login-page-create">
        <div class="form">
            <form action="../php/staff/create.php" method="post" class="login-form">
                <p>Фамилия</p>
                <input required type="text" name="last_name">
                <p>Имя</p>
                <input required type="text" name="first_name">
                <p>Отчество</p>
                <input required type="text" name="middle_name">
                <p>Должность</p>
                <select name="id_post">
                    <option selected disabled>Выберите должность</option>
                    <?php
                    foreach ($posts as $post) {
                    ?>
                        <option value="<?= $post['id'] ?>">
                            <?= $post['title'] ?>
                        </option>
                    <?
                    }
                    ?>
                </select>
                <p>Закреплен за кабинетом</p>
                <select name="id_med_room">
                    <option selected disabled>Выберите кабинет</option>
                    <?php
                    foreach ($med_rooms as $med_room) {
                    ?>
                        <option value="<?= $med_room['id'] ?>">
                            <?= $med_room['title'] ?>
                        </option>
                    <?
                    }
                    ?>
                </select>

                <br><br>
                <button type="submit">Добавить сотрудника</button>
            </form>
        </div>
    </div>
</body>

</html>