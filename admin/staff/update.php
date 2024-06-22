<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id = $_GET['id'];

$staff = mysqli_query($connect, "SELECT * FROM `staff` WHERE `staff`.`id`='$id'") or die(mysqli_error($connect));
$staff = mysqli_fetch_assoc($staff);

$med_roomupd = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `med_room`.`id`='$staff[id_med_room]' ") or die(mysqli_error($connect));
$med_roomupd = mysqli_fetch_assoc($med_roomupd);

$postupd = mysqli_query($connect, "SELECT * FROM `posts` WHERE `posts`.`id`='$staff[id_post]' ") or die(mysqli_error($connect));
$postupd = mysqli_fetch_assoc($postupd);

$posts = mysqli_query($connect, "SELECT * FROM `posts`") or die(mysqli_error($connect));
$med_rooms = mysqli_query($connect, "SELECT * FROM `med_room`") or die(mysqli_error($connect));

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Изменение данных сотрудника</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="login-page-create">
        <div class="form">
            <form action="../php/staff/update.php?id=<?= $id ?>" method="post" class="login-form" enctype="multipart/form-data">

                <p>Фамилия*</p>
                <input required type="text" name="last_name" value="<?= $staff['last_name'] ?>">

                <p>Имя*</p>
                <input required type="text" name="first_name" value="<?= $staff['first_name'] ?>">

                <p>Отчество*</p>
                <input required type="text" name="middle_name" value="<?= $staff['middle_name'] ?>">

                <p>Должность*</p>
                <select required name="id_post">
                    <option selected value="<?= $postupd['id'] ?>"><?= $postupd['title'] ?> </option>
                    <?
                    foreach ($posts as $post) {
                    ?>
                        <option value="<?= $post['id'] ?>">
                            <?= $post['title'] ?>
                        </option>
                    <?
                    }
                    ?>
                </select>

                <p>Закреплен к мед. кабинету*</p>
                <select required name="id_med_room">
                    <option selected value="<?= $med_roomupd['id'] ?>"><?= $med_roomupd['title'] ?> </option>
                    <?
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

                <button type="submit">Изменить данные сотрудника</button>
            </form>
        </div>
    </div>
</body>

</html>