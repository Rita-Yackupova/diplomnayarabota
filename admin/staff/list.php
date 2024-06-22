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
    <title>Сотрудники</title>

    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="table-title">
        <h3>Сотрудники
            <form action="https://medin.bfuunit.ru/admin/staff/list.php?search=<?= $search ?>">
                <input type="text" placeholder="Поиск" name="search">
                <button>
                    Найти
                </button>
            </form>
        </h3>
        <table class="table-fill">

            <thead>

                <tr>

                    <th class="text-left">ФИО</th>
                    <th width="20%" class="text-left">Должность</th>
                    <th width="20%" class="text-left">Закреплен к кабинету (№)</th>

                    <th width="12%" class="text-left"><a href="create.php" style="color:white">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($search != NULL) {
                    $staff = mysqli_query($connect, "SELECT * FROM `staff`  WHERE `first_name` LIKE '%$search%' OR `middle_name` LIKE '%$search%' OR `last_name` LIKE '%$search%'") or die(mysqli_error($connect));
                } else {
                    $staff = mysqli_query($connect, "SELECT * FROM `staff` ") or die(mysqli_error($connect));
                }
                $staffs = mysqli_fetch_all($staff);



                foreach ($staffs as $staff) {

                    $posts = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id`='$staff[4]'") or die(mysqli_error($connect));
                    $posts = mysqli_fetch_assoc($posts);

                    $med_rooms = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `id`='$staff[5]'") or die(mysqli_error($connect));
                    $med_rooms = mysqli_fetch_assoc($med_rooms);
                ?>

                    <tr>
                        <td class="text-left">
                            <?= $staff[3] ?> <?= $staff[1] ?> <?= $staff[2] ?>
                        </td>
                        
                        <td class="text-left">
                            <?= $posts['title'] ?>
                        </td>
                        <td class="text-left">
                            <?= $med_rooms['title'] ?> (<?= $med_rooms['num_room'] ?>)
                        </td>

                        <td class="text-left">
                            <a href="../php/staff/delete.php?id=<?= $staff[0] ?>">Удалить</a>

                            <a href="update.php?id=<?= $staff[0] ?>">Изменить</a>
                        </td>
                    </tr>
                <?
                }
                ?>

            </tbody>

        </table>

</body>

</html>