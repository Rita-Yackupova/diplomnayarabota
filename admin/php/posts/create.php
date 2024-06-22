<?php
require_once '../connect.php';

$title=$_POST['title'];

mysqli_query($connect,"INSERT INTO `posts` (`id`, `title`) 
VALUES (NULL, '$title')");

header("Location: http://medin.bfuunit.ru/admin/posts/list.php");