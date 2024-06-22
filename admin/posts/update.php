<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id = $_GET['id'];

$posts = mysqli_query($connect, "SELECT * FROM `posts` WHERE `posts`.`id`='$id'") or die(mysqli_error($connect));
$posts = mysqli_fetch_assoc($posts);

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
            <form action="../php/posts/update.php?id=<?= $id ?>" method="post" class="login-form" enctype="multipart/form-data">

                <p>Название*</p>
                <input required type="text" name="title" value="<?= $posts['title'] ?>">

                <button type="submit">Изменить данные о должности</button>
            </form>
        </div>
    </div>
</body>

</html>