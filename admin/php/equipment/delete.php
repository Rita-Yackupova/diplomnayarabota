<?php

require_once '../connect.php';

$id=$_GET['id'];

mysqli_query($connect, "DELETE FROM `equipment` WHERE `equipment`.`id` = '$id'");

header('Location: ' . $_SERVER['HTTP_REFERER']);