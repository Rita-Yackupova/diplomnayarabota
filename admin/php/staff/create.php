<?php
require_once '../connect.php';

$first_name=$_POST['first_name'];
$middle_name=$_POST['middle_name'];
$last_name=$_POST['last_name'];
$id_post=$_POST['id_post'];
$id_med_room=$_POST['id_med_room'];

mysqli_query($connect,"INSERT INTO `staff` (`id`, `first_name`, `middle_name`,`last_name`,`id_post`,`id_med_room`) 
VALUES (NULL, '$first_name','$middle_name','$last_name','$id_post','$id_med_room')");

header("Location: http://medin.bfuunit.ru/admin/staff/list.php");