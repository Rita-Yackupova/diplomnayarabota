<?php

session_start();
session_unset();
unset($_SESSION['admin']);
session_destroy();
header("location: http://medin.bfuunit.ru/index.php");
?>
