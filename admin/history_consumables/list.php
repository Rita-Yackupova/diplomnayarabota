<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location:/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$search = $_GET['search'];
$id_med_room = $_GET['id_med_room'];
$start = $_GET['start'];
$end = $_GET['end'];

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>История расходных материалов</title>

    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="table-title">
        <h3>История расходных материалов
            <form
                action="https://medin.bfuunit.ru/admin/history_consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&start=<?= $start ?>&end=<?= $end ?>">
                <input type="text" placeholder="Поиск по названию" name="search">
                <input hidden type="text" value="<?= $id_med_room ?>" name="id_med_room">
                <a style="font-size: 15px; color:white; font-weight:bold;">Дата с <input type="datetime-local"
                        value="<?= $start ?>" name="start">
                    <a style="font-size: 15px; color:white;font-weight:bold;">по <input type="datetime-local" value="<?= $end ?>"
                            name="end">
                        <button>
                            Поиск
                        </button>
            </form>
        </h3>
        <table class="table-fill">

            <thead>

                <tr>

                    <th width="8%" class="text-left">Действие </th>
                    <th class="text-left">Название</th>
                    <th width="7%" class="text-left">Количество</th>
                    <th width="20%" class="text-left">Кем выполнено</th>
                    <th width="13%" class="text-left">Дата и время </th>
                    <th width="10%" class="text-left">Мед. кабинет </th>
                    <th width="5%"><a style="color:white"
                            href="export_excel_history_consumables.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=<?= $sort ?>&column=<?= $column ?>">Экспорт
                            </>
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php
                if ($id_med_room != NULL) {
                    if ($search != NULL and $start != NULL and $end != NULL) {

                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `id_med_room`=$id_med_room AND (`date` >= '$start' AND `date` <='$end')  AND (`title` LIKE '%$search%' OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($start != NULL and $end != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `date` >= '$start' AND `date` <='$end'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    }elseif ($search != NULL and $start != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `id_med_room`=$id_med_room AND `date` >= '$start' AND (`title` LIKE '%$search%' OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($search != NULL and $end != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `id_med_room`=$id_med_room AND `date` <= '$end' AND (`title` LIKE '%$search%' OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($end != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `id_med_room`=$id_med_room AND `date` <= '$end'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($start != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `id_med_room`=$id_med_room AND `date` >= '$start'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($search != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `id_med_room`=$id_med_room AND  (`title` LIKE '%$search%' OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } else {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables` WHERE `id_med_room`=$id_med_room ORDER BY `date` DESC  ") or die(mysqli_error($connect));
                    }
                } else {
                    if ($search != NULL and $start != NULL and $end != NULL) {

                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE (`date` >= '$start' AND `date` <='$end')  AND (`title` LIKE '%$search%' OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($start != NULL and $end != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `date` >= '$start' AND `date` <='$end'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    }elseif ($search != NULL and $start != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `date` >= '$start' AND (`title` LIKE '%$search%' OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($search != NULL and $end != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `date` <= '$end' AND (`title` LIKE '%$search%'  OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($end != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `date` <= '$end'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($start != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `date` >= '$start'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } elseif ($search != NULL) {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `title` LIKE '%$search%' OR `action`  LIKE '%$search%'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
                    } else {
                        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables` ORDER BY `date` DESC  ") or die(mysqli_error($connect));
                    }
                }

                $history_consumables = mysqli_fetch_all($history_consumables);

                foreach ($history_consumables as $history_consumable) {

                    $med_rooms = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `id`='$history_consumable[6]'") or die(mysqli_error($connect));
                    $med_rooms = mysqli_fetch_assoc($med_rooms);

                    $admins = mysqli_query($connect, "SELECT * FROM `admins` WHERE `id`='$history_consumable[5]'") or die(mysqli_error($connect));
                    $admins = mysqli_fetch_assoc($admins);

                    $role = mysqli_query($connect, "SELECT * FROM `roles` WHERE `id`='$admins[id_role]'") or die(mysqli_error($connect));
                    $role = mysqli_fetch_assoc($role);

                    ?>

                    <tr>

                        <td>
                            <?= $history_consumable[2] ?>
                        </td>

                        <td>
                            <?= $history_consumable[1] ?>
                        </td>

                        <td>
                            <?= $history_consumable[3] ?>
                        </td>
                        <td>
                            <?= $admins['name'] ?> (<?= $role['title'] ?>)
                        </td>
                        <td>
                            <?= $history_consumable[7] ?>
                        </td>

                        <td>
                            <?= $med_rooms['title'] ?>
                        </td>
                        <td>
                            <a href="../php/history_consumables/delete.php?id=<?= $history_consumable[0] ?>">Удалить</a>
                        </td>

                    </tr>

                    <?php
                }
                ?>

            </tbody>

        </table>

</body>

</html>