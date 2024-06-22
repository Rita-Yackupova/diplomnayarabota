<?php
require_once '../connect.php';

$id = $_GET['id'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$id_post = $_POST['id_post'];
$id_med_room = $_POST['id_med_room'];

mysqli_query($connect, "UPDATE `staff` SET 
`first_name`='$first_name',
`middle_name`='$middle_name', 
`last_name`='$last_name',
`id_post`='$id_post',
`id_med_room`='$id_med_room'
WHERE `staff`.`id`=$id");

header("Location: http://medin.bfuunit.ru/admin/staff/list.php");
