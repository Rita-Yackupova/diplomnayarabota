<?php

require_once '../connect.php';

$id=$_GET['id'];

mysqli_query($connect, "DELETE FROM `consumables` WHERE `consumables`.`id` = '$id'");

header('Location: ' . $_SERVER['HTTP_REFERER']);