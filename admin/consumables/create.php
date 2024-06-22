<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}

include "../menu.php";
$id_med_room = $_GET['id_med_room'];
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
            <form action="../php/consumables/create.php?id_med_room=<?= $id_med_room ?>" method="post" class="login-form">
                <p>Название материала</p>
                <input required type="text" name="title">
                <p>Количество</p>
                <input required type="number" min="1" name="amount">
                <p>Дата покупки</p>
                <input required type="date" name="date">
                <p>Срок годности до</p>
                <input required type="date" name="expiration_date">
                <p>Стоимость</p>
                <input required type="number" min="1" name="price">

                <br><br>
                <button type="submit">Добавить материал</button>
            </form>
        </div>
    </div>
</body>

</html>