<?php
session_start();

require_once '../connect.php';

$login = $_POST['login'];
$password = $_POST['password'];

$check_admin = mysqli_query($connect, "SELECT * FROM `admins` WHERE `login` = '$login' AND `password` = '$password'");

if (mysqli_num_rows($check_admin) > 0) {
    $admin = mysqli_fetch_assoc($check_admin);


    $_SESSION['admin'] = [
        "id" => $admin['id'],
        "name" => $admin['name'],
        "id_role"=> $admin['id_role']
    ];


    

    header('Location: http://medin.bfuunit.ru/admin/equipment/list.php');

} else {
    $_SESSION['message'] = 'Не верный логин или пароль';
    header('Location: http://medin.bfuunit.ru/admin/index.php');
}