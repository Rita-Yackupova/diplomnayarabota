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
        <h3>Администраторы
            <form action="https://medin.bfuunit.ru/admin/admins/list.php?search=<?= $search ?>">
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
                    <th width="20%" class="text-left">Роль</th>

                    <th width="12%" class="text-left"><a href="create.php" style="color:white">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($search != NULL) {
                    $admins = mysqli_query($connect, "SELECT * FROM `admins`  WHERE `name` LIKE '%$search%' ") or die(mysqli_error($connect));
                } else {
                    $admins = mysqli_query($connect, "SELECT * FROM `admins` ") or die(mysqli_error($connect));
                }
                $admins = mysqli_fetch_all($admins);



                foreach ($admins as $admin) {
                    $roles = mysqli_query($connect, "SELECT * FROM `roles` WHERE `id`='$admin[4]'") or die(mysqli_error($connect));
                    $roles = mysqli_fetch_assoc($roles);
                    ?>

                    <tr>
                        <td class="text-left">
                            <?= $admin[1] ?>
                        </td>

                        <td class="text-left">
                            <?= $roles['title'] ?>
                        </td>


                        <td class="text-left">
                            <a href="../php/admins/delete.php?id=<?= $admin[0] ?>">Удалить</a>

                            <a href="update.php?id=<?= $admin[0] ?>">Изменить</a>
                        </td>
                    </tr>
                <?
                }
                ?>

            </tbody>

        </table>

</body>

</html>