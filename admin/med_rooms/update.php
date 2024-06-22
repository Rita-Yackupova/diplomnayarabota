<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://bible.bfuunit.ru/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id = $_GET['id'];

$med_room = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `med_room`.`id`='$id'") or die(mysqli_error($connect));
$med_room = mysqli_fetch_assoc($med_room);

$staffupd = mysqli_query($connect, "SELECT * FROM `staff` WHERE `staff`.`id`='$med_room[id_responsible]' ") or die(mysqli_error($connect));
$staffupd = mysqli_fetch_assoc($staffupd);

$staff = mysqli_query($connect, "SELECT * FROM `staff` ") or die(mysqli_error($connect));

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление литературы</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="login-page-create">
        <div class="form">
            <form action="../php/med_rooms/update.php?id=<?= $id ?>" method="post" class="login-form" enctype="multipart/form-data">


                <p>Название*</p>
                <input required type="text" name="title" value="<?= $med_room['title'] ?>">

                <p>Номер кабинета*</p>
                <input required type="text" name="num_room" value="<?= $med_room['num_room'] ?>">

                <p>Ответственный за кабинет*</p>
                <select required name="id_responsible">
                    <? if ($med_room['id_responsible'] == 0) { ?>
                        <option selected>Выберите ответственное лицо </option>
                    <? } else {
                    ?>
                        <option selected value="<?= $staffupd['id'] ?>">Выбрано: <?= $staffupd['last_name'] ?> <?= $staffupd['first_name'] ?> <?= $staffupd['middle_name'] ?> </option>
                    <? }
                    foreach ($staff as $staffs) {
                    ?>
                        <option value="<?= $staffs['id'] ?>">
                            <?= $staffs['last_name'] ?> <?= $staffs['first_name'] ?> <?= $staffs['middle_name'] ?>
                        </option>
                    <?
                    }
                    ?>
                </select>





                <button type="submit">Изменить данные о мед. кабинете</button>
            </form>
        </div>
    </div>
</body>

</html>