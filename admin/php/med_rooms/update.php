<?php
require_once '../connect.php';

$id = $_GET['id'];
$title = $_POST['title'];
$num_room = $_POST['num_room'];
$id_responsible = $_POST['id_responsible'];

mysqli_query($connect, "UPDATE `med_room` SET 
`title`='$title',
`num_room`='$num_room',
 `id_responsible`='$id_responsible' 
 WHERE `med_room`.`id`=$id");

header("Location: http://medin.bfuunit.ru/admin/med_rooms/list.php");
