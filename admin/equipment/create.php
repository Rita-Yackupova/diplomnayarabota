<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}

include "../menu.php";

$id_med_room = $_GET['id_med_room'];

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
            <form action="../php/equipment/create.php?id_med_room=<?= $id_med_room ?>" method="post" class="login-form">
                <p>Название оборудования</p>
                <input required type="text" name="title">
                <p>Фирма</p>
                <input required type="text" name="manufacturer">
                <p>Модель</p>
                <input required type="text" name="model">
                <p>Серийный номер</p>
                <input required type="text" name="serial_number">
                <p>Дата покупки</p>
                <input required type="date" name="date">
                <p>Гарантия до</p>
                <input required type="date" name="guarantee_period">
                <p>Стоимость</p>
                <input required type="number" min="1" name="price">
                <p>Статус</p>
                <select name="id_status">
                    <option selected disabled>Выберите статус</option>
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
                <button type="submit">Добавить оборудование</button>
            </form>
        </div>
    </div>
</body>

</html>