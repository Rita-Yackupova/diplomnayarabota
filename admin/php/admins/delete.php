<?php

require_once '../connect.php';

$id=$_GET['id'];

mysqli_query($connect, "DELETE FROM `admins` WHERE `admins`.`id` = '$id'");

header("Location: http://medin.bfuunit.ru/admin/admins/list.php");