<?php
require_once '../connect.php';

$id = $_GET['id'];
$title = $_POST['title'];

mysqli_query($connect, "UPDATE `posts` SET 
`title`='$title'
WHERE `posts`.`id`=$id");

header("Location: http://medin.bfuunit.ru/admin/posts/list.php");
