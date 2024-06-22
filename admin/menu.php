<?php
session_start();

require_once "php/connect.php";

$med_rooms = mysqli_query($connect, "SELECT * FROM `med_room` ") or die(mysqli_error($connect));
$med_rooms = mysqli_fetch_all($med_rooms);
$id_role = $_SESSION["admin"]["id_role"];
?>

<nav class="menu">
    <ul>
        <? if ($_SESSION['admin']) { ?>
            <li><a href="https://medin.bfuunit.ru/admin/equipment/list.php">Оборудование</a>
                <ul class="submenu">
                    <?
                    foreach ($med_rooms as $med_room) {
                        ?>
                        <li class="submenu"><a
                                href="https://medin.bfuunit.ru/admin/equipment/list.php?id_med_room=<?= $med_room[0] ?>"><?= $med_room[1] ?></a>
                        </li>

                    <? }
                    ?>
                </ul>
            </li>
            <li><a href="https://medin.bfuunit.ru/admin/consumables/list.php">Расход. материалы</a>
                <ul class="submenu">
                    <?
                    foreach ($med_rooms as $med_room) {
                        ?>
                        <li class="submenu"><a
                                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $med_room[0] ?>"><?= $med_room[1] ?></a>
                        </li>

                    <? }
                    ?>
                </ul>
            </li>
            <li><a href="https://medin.bfuunit.ru/admin/med_rooms/list.php">Мед. кабинеты</a></li>
            <li><a href="https://medin.bfuunit.ru/admin/staff/list.php">Сотрудники</a></li>
            <li><a href="https://medin.bfuunit.ru/admin/posts/list.php">Должности</a></li>
            <li><a href="https://medin.bfuunit.ru/admin/history_consumables/list.php">История расходов</a>
                <ul class="submenu">
                    <?
                    foreach ($med_rooms as $med_room) {
                        ?>
                        <li class="submenu"><a
                                href="https://medin.bfuunit.ru/admin/history_consumables/list.php?id_med_room=<?= $med_room[0] ?>"><?= $med_room[1] ?></a>
                        </li>

                    <? }
                    ?>
                </ul>
            </li>
            <? if ($id_role == 1) {?>
                <li><a href="https://medin.bfuunit.ru/admin/admins/list.php">Админы</a></li>
            <? } ?>
            <li><a href="http://medin.bfuunit.ru/admin/php/auth/logout.php">Выход</a></li>




        <? } else {
            ?>
            <li><a href="http://medin.bfuunit.ru/index.php">Назад</a></li>
        <?
        }
        ?>

    </ul>
</nav>