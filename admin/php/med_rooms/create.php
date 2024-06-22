<?php
require_once '../connect.php';

$title=$_POST['title'];
$num_room=$_POST['num_room'];
$id_responsible=$_POST['id_responsible'];

mysqli_query($connect,"INSERT INTO `med_room` (`id`, `title`, `num_room`,`id_responsible`) 
VALUES (NULL, '$title','$num_room','$id_responsible')");

header("Location: http://medin.bfuunit.ru/admin/med_rooms/list.php");