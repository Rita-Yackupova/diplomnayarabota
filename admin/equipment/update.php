<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}

include "../menu.php";
require_once '../php/connect.php';

$id = $_GET['id'];

$id_med_room = $_GET['id_med_room'];

$equipment = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `equipment`.`id`='$id'") or die(mysqli_error($connect));
$equipment = mysqli_fetch_assoc($equipment);

$statusupd = mysqli_query($connect, "SELECT * FROM `equipment_status` WHERE `equipment_status`.`id`='$equipment[id_status]' ") or die(mysqli_error($connect));
$statusupd = mysqli_fetch_assoc($statusupd);

$equipment_status = mysqli_query($connect, "SELECT * FROM `equipment_status`") or die(mysqli_error($connect));
?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление оборудования</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="login-page-create">
        <div class="form">
            <form action="../php/equipment/update.php?id_med_room=<?= $id_med_room ?>&id=<?= $id ?>" method="post" class="login-form">
                <p>Название оборудования</p>
                <input required type="text" name="title"  value="<?= $equipment['title']?>">
                <p>Фирма</p>
                <input required type="text" name="manufacturer" value="<?= $equipment['manufacturer']?>">
                <p>Модель</p>
                <input required type="text" name="model" value="<?= $equipment['model']?>">
                <p>Серийный номер</p>
                <input required type="text" name="serial_number" value="<?= $equipment['serial_number']?>">
                <p>Дата покупки</p>
                <input required type="date" name="date" value="<?= $equipment['date']?>">
                <p>Гарантия до</p>
                <input required type="date" name="guarantee_period" value="<?= $equipment['guarantee_period']?>">
                <p>Стоимость</p>
                <input required type="number" min="1" name="price" value="<?= $equipment['price']?>">
                <p>Статус</p>
                <select required name="id_status">
                <option selected value="<?= $statusupd['id'] ?>"><?= $statusupd['title'] ?> </option>
                    <?php
                    foreach ($equipment_status as $equipment_statuses) {
                    ?>
                        <option value="<?= $equipment_statuses['id'] ?>">
                            <?= $equipment_statuses['title'] ?>
                        </option>
                    <?
                    }
                    ?>
                </select>

               

                <button type="submit">Обновить оборудование</button>
            </form>
        </div>
    </div>
</body>

</html>