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
    <title>Список должностей</title>

    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="table-title">
        <h3>Список должностей
            <form action="https://medin.bfuunit.ru/admin/posts/list.php?search=<?= $search ?>">
                <input type="text" placeholder="Поиск" name="search">
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

                    <th width="12%" class="text-left"><a href="create.php" style="color:white">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($search != NULL) {
                    $posts = mysqli_query($connect, "SELECT * FROM `posts`  WHERE `title` LIKE '%$search%'") or die(mysqli_error($connect));
                } else {
                    $posts = mysqli_query($connect, "SELECT * FROM `posts` ") or die(mysqli_error($connect));
                }
                $posts = mysqli_fetch_all($posts);

                foreach ($posts as $post) {
                ?>

                    <tr>

                        <td class="text-left">
                            <?= $post[0] ?>
                        </td>
                        <td class="text-left">
                            <?= $post[1] ?>
                        </td>


                        <td class="text-left">
                            <a href="update.php?id=<?= $post[0] ?>">Изменить</a>
                            <a href="../php/post/delete.php?id=<?= $post[0] ?>">Удалить</a>


                        </td>
                    </tr>
                <?
                }
                ?>

            </tbody>

        </table>

</body>

</html>