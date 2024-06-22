<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}

require_once '../php/connect.php';
include "../menu.php";

$staff = mysqli_query($connect, "SELECT * FROM `staff`") or die(mysqli_error($connect));

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
            <form action="../php/med_rooms/create.php" method="post" class="login-form">
                <p>Название</p>
                <input required type="text" name="title">
                <p>Номер кабинета</p>
                <input required type="text" name="num_room">
                <p>Отвественный за кабинет</p>
                <select name="id_responsible">
                    <option selected disabled>Выберите ответственное лицо</option>
                    <?php
                    foreach ($staff as $staffs) {
                    ?>
                        <option value="<?= $staffs['id'] ?>">
                            <?= $staffs['last_name'] ?> <?= $staffs['first_name'] ?> <?= $staffs['middle_name'] ?>
                        </option>
                    <?
                    }
                    ?>
                </select>


                <br><br>
                <button type="submit">Добавить мед. кабинет</button>
            </form>
        </div>
    </div>
</body>

</html>