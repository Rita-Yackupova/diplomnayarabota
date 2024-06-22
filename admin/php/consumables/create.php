<?php
session_start();

require_once '../connect.php';

date_default_timezone_set("Asia/Yekaterinburg");

$id_med_room = $_GET['id_med_room'];
$title = $_POST['title'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$expiration_date = $_POST['expiration_date'];
$price = $_POST['price'];

mysqli_query($connect, "INSERT INTO `consumables` (`id`, `title`,`amount`,`date`,`expiration_date`,`price`,`id_med_room`) 
VALUES (NULL, '$title','$amount','$date','$expiration_date','$price','$id_med_room')");

$consumables = mysqli_query($connect, "SELECT `id` FROM `consumables` ORDER BY `id` DESC LIMIT 1") or die(mysqli_error($connect));
$consumables = mysqli_fetch_assoc($consumables);

$today = date("Y-m-d H:i:s");
$id_consumables = $consumables['id'];
$id_admin=$_SESSION['admin']['id'];

mysqli_query($connect, "INSERT INTO `history_consumables` (`id`,`title`,`action`, `amount`,`id_consumable`,`id_admin`,`date`,`id_med_room`) 
VALUES (NULL,'$title','Добавлено','$amount','$id_consumables','$id_admin','$today','$id_med_room')");

if ($id_med_room != NULL) {
    header("Location: http://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=$id_med_room");
} else {
    header("Location: http://medin.bfuunit.ru/admin/consumables/list.php");
}
