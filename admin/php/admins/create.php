<?php
require_once '../connect.php';

$name=$_POST['name'];
$id_role=$_POST['id_role'];
$login=$_POST['login'];
$password=$_POST['password'];

mysqli_query($connect,"INSERT INTO `admins` (`id`, `name`, `id_role`,`login`,`password`) 
VALUES (NULL, '$name','$id_role','$login','$password')");

header("Location: http://medin.bfuunit.ru/admin/admins/list.php");