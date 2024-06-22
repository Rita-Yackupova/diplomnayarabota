<?php

require_once '../connect.php';

$id=$_GET['id'];

mysqli_query($connect, "DELETE FROM `posts` WHERE `posts`.`id` = '$id'");

header("Location: http://medin.bfuunit.ru/admin/posts/list.php");