<?php

require_once '../connect.php';

$id=$_GET['id'];

mysqli_query($connect, "DELETE FROM `med_room` WHERE `med_room`.`id` = '$id'");

header('Location: ' . $_SERVER['HTTP_REFERER']);