<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location:/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$search = $_GET['search'];

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Мед. кабинеты</title>

    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="table-title">
        <h3>Мед. кабинеты
            <form action="https://medin.bfuunit.ru/admin/med_rooms/list.php?search=<?= $search ?>">
                <input type="text" placeholder="Поиск по названию" name="search">
                <button>
                    Найти
                </button>
            </form>
        </h3>
        <table class="table-fill">
            <thead>
                <tr>
                    <th width="2%" class="text-left">№</th>
                    <th class="text-left">Название</th>
                    <th class="text-left">Заведующий мед. кабинета</th>
                    <th class="text-left">Закрепленные сотрудники</th>
                    <th width="12%" class="text-left"><a href="create.php" style="color:white">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($search != NULL) {
                    $med_rooms = mysqli_query($connect, "SELECT * FROM `med_room`  WHERE `title` LIKE '%$search%'") or die(mysqli_error($connect));
                } else {
                    $med_rooms = mysqli_query($connect, "SELECT * FROM `med_room` ") or die(mysqli_error($connect));
                }
                $med_rooms = mysqli_fetch_all($med_rooms);

                foreach ($med_rooms as $med_room) {
                    $staff = mysqli_query($connect, "SELECT * FROM `staff` WHERE `id`='$med_room[3]'") or die(mysqli_error($connect));
                    $staff = mysqli_fetch_assoc($staff);


                    ?>
                    <tr>
                        <td class="text-left">
                            <?= $med_room[2] ?>
                        </td>
                        <td class="text-left">
                            <?= $med_room[1] ?>
                        </td>

                        <td class="text-left">
                            <? if ($med_room[3] == NULL or $med_room[3] == 0) { ?>
                                Нет заведующего
                            <? } else { ?>
                                <?= $staff['last_name'] ?>
                                <?= $staff['first_name'] ?>
                                <?= $staff['middle_name'] ?>
                            <? } ?>
                        </td>
                        <td>
                            <?
                            $staffs = mysqli_query($connect, "SELECT * FROM `staff` WHERE `id_med_room`='$med_room[0]'") or die(mysqli_error($connect));
                            $staffs = mysqli_fetch_all($staffs);

                            if ($staffs == null) {?>
                                Нет закрепленных
                            <?} else {
                                foreach ($staffs as $staff2) { ?>
                                    <?= $staff2[3] ?>
                                    <?= $staff2[1] ?>
                                    <?= $staff2[2] ?>
                                    <br>
                                <? }
                            } ?>

                        </td>
                        <td class="text-left">
                            <a href="update.php?id=<?= $med_room[0] ?>">Изменить</a>
                            <a href="../php/med_rooms/delete.php?id=<?= $med_room[0] ?>">Удалить</a>
                        </td>
                    </tr>
                <?
                }
                ?>
            </tbody>
        </table>
</body>

</html>