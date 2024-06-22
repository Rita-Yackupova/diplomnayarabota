<?php
session_start();

if (!$_SESSION['admin']) {
  header('Location:/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$search = $_GET['search'];
$id_med_room = $_GET['id_med_room'];
$sort = $_GET['sort'];
$column = $_GET['column'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Расходные материалы</title>

  <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
  <div class="table-title">
    <h3>Расходные материалы
      <form
        action="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=<?= $sort ?>&column=<?= $column ?>">
        <input type="text" placeholder="Поиск" name="search">
        <input hidden type="text" value="<?= $id_med_room ?>" name="id_med_room">
        <input hidden type="text" value="<?= $sort ?>" name="sort">
        <input hidden type="text" value="<?= $column ?>" name="column">
        <button>
          Поиск
        </button>
      </form>
    </h3>
    <table class="table-fill">

      <thead>

        <tr>

          <th class="text-left">Название
            <? if ($sort == "asc_title" and $column == "title") { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=title"><button>&#9650</button></a>
            <? } else { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=title"><button>&#9660</button></a>
            <? } ?>
          </th>
          <th width="10%" class="text-left">Количество
            <? if ($sort == "asc_title" and $column == "amount") { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=amount"><button>&#9650</button></a>
            <? } else { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=amount"><button>&#9660</button></a>
            <? } ?>
          </th>
          <th width="12%" class="text-left">Дата покупки
            <? if ($sort == "asc_title" and $column == "date") { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=date"><button>&#9650</button></a>
            <? } else { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=date"><button>&#9660</button></a>
            <? } ?>
          </th>
          <th class="text-left">Срок годности
            <? if ($sort == "asc_title" and $column == "expiration_date") { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=expiration_date"><button>&#9650</button></a>
            <? } else { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=expiration_date"><button>&#9660</button></a>
            <? } ?>
          </th>
          <th width="10%" class="text-left">Стоимость
            <? if ($sort == "asc_title" and $column == "price") { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=price"><button>&#9650</button></a>
            <? } else { ?>
              <a
                href="https://medin.bfuunit.ru/admin/consumables/list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=price"><button>&#9660</button></a>
            <? } ?>
          </th>
          <th width="10%" class="text-left">Мед. кабинет</th>

          <? if ($id_med_room != NULL) {
            ?>
            <th width="10%" class="text-left"><a href="create.php?id_med_room=<?= $id_med_room ?>"
                style="color:white">Добавить</a></th>
          <? } ?>
        </tr>
      </thead>

      <tbody>
        <?php

        if ($id_med_room != NULL and $search != NULL) {
          if ($sort == "asc_title") {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%' ORDER BY `$column` ASC") or die(mysqli_error($connect));
          } elseif ($sort == "desc_title") {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%' ORDER BY `$column` DESC") or die(mysqli_error($connect));
          } else {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%' ") or die(mysqli_error($connect));
          }
          $res = mysqli_query($connect, "SELECT SUM(`amount`) FROM `consumables` WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%'");
          $row = mysqli_fetch_row($res);
          $amount = $row[0];

          $res = mysqli_query($connect, "SELECT SUM(`price`) FROM `consumables` WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%'");
          $row = mysqli_fetch_row($res);
          $price = $row[0];
        } elseif ($search != NULL) {
          if ($sort == "asc_title") {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  WHERE  `title` LIKE '%$search%' ORDER BY `$column` ASC") or die(mysqli_error($connect));
          } elseif ($sort == "desc_title") {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  WHERE  `title` LIKE '%$search%' ORDER BY `$column` DESC") or die(mysqli_error($connect));
          } else {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  WHERE `title` LIKE '%$search%' ") or die(mysqli_error($connect));
          }


          $res = mysqli_query($connect, "SELECT SUM(`amount`) FROM `consumables` WHERE `title` LIKE '%$search%'");
          $row = mysqli_fetch_row($res);
          $amount = $row[0];

          $res = mysqli_query($connect, "SELECT SUM(`price`) FROM `consumables` WHERE `title` LIKE '%$search%'");
          $row = mysqli_fetch_row($res);
          $price = $row[0];
        } elseif ($id_med_room != NULL) {
          if ($sort == "asc_title") {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`   WHERE `id_med_room`=$id_med_room ORDER BY `$column` ASC") or die(mysqli_error($connect));
          } elseif ($sort == "desc_title") {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`   WHERE `id_med_room`=$id_med_room ORDER BY `$column` DESC") or die(mysqli_error($connect));
          } else {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  WHERE `id_med_room`=$id_med_room ") or die(mysqli_error($connect));
          }

          $res = mysqli_query($connect, "SELECT SUM(`amount`) FROM `consumables` WHERE `id_med_room`=$id_med_room");
          $row = mysqli_fetch_row($res);
          $amount = $row[0];

          $res = mysqli_query($connect, "SELECT SUM(`price`) FROM `consumables` WHERE `id_med_room`=$id_med_room");
          $row = mysqli_fetch_row($res);
          $price = $row[0];
        } else {
          if ($sort == 'asc_title') {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  ORDER BY `$column` ASC") or die(mysqli_error($connect));
          } elseif ($sort == 'desc_title') {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables`  ORDER BY `$column` DESC") or die(mysqli_error($connect));
          } else {
            $consumables = mysqli_query($connect, "SELECT * FROM `consumables` ") or die(mysqli_error($connect));
          }
          $res = mysqli_query($connect, "SELECT SUM(`amount`) FROM `consumables`");
          $row = mysqli_fetch_row($res);
          $amount = $row[0];

          $res = mysqli_query($connect, "SELECT SUM(`price`) FROM `consumables`");
          $row = mysqli_fetch_row($res);
          $price = $row[0];
        }

        $consumables = mysqli_fetch_all($consumables);

        foreach ($consumables as $consumable) {

          $med_room = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `id`='$consumable[6]'") or die(mysqli_error($connect));
          $med_room = mysqli_fetch_assoc($med_room);
          ?>

          <tr>
            <td class="text-left">
              <?= $consumable[1] ?>
            </td>
            <td class="text-left">
              <?= $consumable[2] ?> Шт.
            </td>
            <td class="text-left">
              <?= $consumable[3] ?>
            </td>
            <?
            $now = new DateTime(date("Y/m/d"));
            $ref = new DateTime($consumable[4]);
            $diff = $now->diff($ref);
            $years = $diff->y;
            $months = $diff->m;
            $days = $diff->d;
            if ($now > $ref) {

              ?>
              <td style="background-color: red; color:white;">
                Срок годности истек
              </td>
            <?
            } else {
              if ($years >= 1) {
                ?>
                <td style="background-color: green; color:white;">
                  <?= $consumable[4] ?>
                  (Осталось:
                  <?=
                    $years . " г. " . $months . " мес. " . $days . " д."
                    ?>)
                </td>
              <? } elseif ($months >= 1) {
                ?>
                <td style="background-color: green; color:white;">
                  <?= $consumable[4] ?>
                  (Осталось:
                  <?=
                    $months . " мес. " . $days . " д."
                    ?>)
                </td>
              <? } else {
                ?>
                <td style="background-color: orange; color:white;">
                  <?= $consumable[4] ?>
                  (Осталось:
                  <?=
                    $days . " д."
                    ?>)
                </td>
              <?
              }
            }
            ?>
            <td class="text-left">
              <?= $consumable[5] ?> Руб.
            </td>
            <td class="text-left">
              <?= $med_room['title'] ?>
            </td>
            <? if ($id_med_room != NULL) {
              ?>
              <td class="text-left">
                <a href="../php/consumables/delete.php?id=<?= $consumable[0] ?>">Удалить</a>
                <br>
                <? if ($consumable[2] > 0) { ?>
                  <a href="consumable_use.php?id_med_room=<?= $id_med_room ?>&id=<?= $consumable[0] ?>">Использовано</a>
                <? } ?>
              </td>
            <? } ?>

          </tr>
          <?php

        }
        ?>
        <td>Итого количество:</td>
        <td>
          <?= $amount ?> Шт.
        </td>
        <td colspan="2">Итого cумма:</td>
        <td>
          <?= $price ?> Руб.
        </td>
        <td>
          <a
            href="https://medin.bfuunit.ru/admin/consumables/export_excel_consumables.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=<?= $sort ?>&column=<?= $column ?>">Экспорт</a>
        </td>
      </tbody>
    </table>

</body>

</html>