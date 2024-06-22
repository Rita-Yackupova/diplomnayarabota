<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id = $_GET['id'];
$id_med_room = $_GET['id_med_room'];

$consumables = mysqli_query($connect, "SELECT * FROM `consumables` WHERE `consumables`.`id`='$id'") or die(mysqli_error($connect));
$consumables = mysqli_fetch_assoc($consumables);

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Использованые материала</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="login-page-create">
        <div class="form">
            <form action="../php/consumables/consumable_use.php?id_med_room=<?= $id_med_room ?>&id=<?= $id ?>" method="post" class="login-form" enctype="multipart/form-data">

                <p>Расходный материал*</p>
                <input required type="text" name="title" value="<?= $consumables['title'] ?>">

                <p>Количество (осталось: <?=$consumables['amount']?>)</p>
                <input hidden type="number" name="amount_old" value="<?=$consumables['amount']?>">
                <input required type="number" name="amount" min="0" max="<?=$consumables['amount']?>">

<br><br>

                <button type="submit">Использовано материала</button>
            </form>
        </div>
    </div>
</body>

</html>