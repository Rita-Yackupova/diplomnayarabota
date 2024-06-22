<?php

session_start();

require_once '../connect.php';

date_default_timezone_set("Asia/Yekaterinburg");

$id = $_GET['id'];
$id_med_room = $_GET['id_med_room'];

$title=$_POST['title'];
$amount = $_POST['amount'];
$amount_old = $_POST['amount_old'];
$amount_new=$_POST['amount_old'] - $_POST['amount'];

mysqli_query($connect, "UPDATE `consumables` SET 
`amount`='$amount_new'
WHERE `consumables`.`id`=$id");

$today = date("Y-m-d H:i:s");
$id_consumables = $consumables['id'];
$id_admin=$_SESSION['admin']['id'];

mysqli_query($connect, "INSERT INTO `history_consumables` (`id`,`title`,`action`, `amount`,`id_consumable`,`id_admin`,`date`,`id_med_room`) 
VALUES (NULL,'$title','Использовано','$amount','$id','$id_admin','$today','$id_med_room')");

if ($id_med_room != NULL) {
    header("Location: http://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=$id_med_room");
} else {
    header("Location: http://medin.bfuunit.ru/admin/consumables/list.php");
}