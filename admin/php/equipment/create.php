<?php
require_once '../connect.php';

$id_med_room = $_GET['id_med_room'];
$title=$_POST['title'];
$manufacturer=$_POST['manufacturer'];
$model=$_POST['model'];
$serial_number=$_POST['serial_number'];
$date=$_POST['date'];
$guarantee_period=$_POST['guarantee_period'];
$price=$_POST['price'];
$id_status=$_POST['id_status'];

mysqli_query($connect,"INSERT INTO `equipment` (`id`, `title`, `manufacturer`,`model`,`serial_number`,`date`,`guarantee_period`,`price`,`id_status`,`id_med_room`) 
VALUES (NULL, '$title','$manufacturer','$model','$serial_number','$date','$guarantee_period','$price','$id_status','$id_med_room')");

if ($id_med_room != NULL) {
    header("Location: http://medin.bfuunit.ru/admin/equipment/list.php?id_med_room=$id_med_room");
} else {
    header("Location: http://medin.bfuunit.ru/admin/equipment/list.php");
}