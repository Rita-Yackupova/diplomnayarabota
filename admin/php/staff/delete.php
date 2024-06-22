<?php

require_once '../connect.php';

$id=$_GET['id'];

mysqli_query($connect, "DELETE FROM `staff` WHERE `staff`.`id` = '$id'");

header("Location: http://medin.bfuunit.ru/admin/staff/list.php");