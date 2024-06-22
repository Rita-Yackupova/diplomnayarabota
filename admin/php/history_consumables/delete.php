<?php

require_once '../connect.php';

$id=$_GET['id'];

mysqli_query($connect, "DELETE FROM `history_consumables` WHERE `history_consumables`.`id` = '$id'");

header('Location: ' . $_SERVER['HTTP_REFERER']);