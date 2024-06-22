<?php
session_start();

require_once "connect.php";

$med_rooms = mysqli_query($connect, "SELECT * FROM `med_room` ") or die(mysqli_error($connect));
$med_rooms = mysqli_fetch_all($med_rooms);
?>

<nav class="menu">
    <ul>
    <li><a href="https://medin.bfuunit.ru/equipment_list.php">Оборудование</a>
            <ul class="submenu">
                <?
                foreach ($med_rooms as $med_room) {
                ?>
                    <li class="submenu"><a href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $med_room[0] ?>"><?= $med_room[1] ?></a></li>

                <? }
                ?>
            </ul>
        </li>
        <li><a href="https://medin.bfuunit.ru/consumables_list.php">Расходные материалы</a>
            <ul class="submenu">
                <?
                foreach ($med_rooms as $med_room) {
                ?>
                    <li class="submenu"><a href="https://medin.bfuunit.ru/consumables_list.php?id_med_room=<?= $med_room[0] ?>"><?= $med_room[1] ?></a></li>

                <? }
                ?>
            </ul>
        </li>
        
        <li><a href="http://medin.bfuunit.ru/admin/index.php">Администрирование</a></li>
    </ul>
</nav>