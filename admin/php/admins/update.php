<?php
require_once '../connect.php';

$id = $_GET['id'];
$name=$_POST['name'];
$id_role=$_POST['id_role'];
$login=$_POST['login'];
$password=$_POST['password'];

mysqli_query($connect, "UPDATE `admins` SET 
`name`='$name',
`id_role`='$id_role', 
`login`='$login',
`password`='$password'
WHERE `admins`.`id`=$id");

header("Location: http://medin.bfuunit.ru/admin/admins/list.php");
