<?php

require_once 'connect.php';
include "menu.php";

$search = $_GET['search'];
$id_med_room = $_GET['id_med_room'];
$sort = $_GET['sort'];
$column = $_GET['column'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Оборудование</title>

  <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
  <div class="table-title">
    <h3>Оборудование
      <form action="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=<?= $sort ?>&column=<?= $column?>">
        <input type="text" placeholder="Поиск" name="search">
        <input hidden type="text" value="<?= $id_med_room ?>" name="id_med_room">
        <input hidden type="text" value="<?= $sort ?>" name="sort">
        <input hidden type="text" value="<?= $column ?>" name="column">
        <button type="submit">
          Поиск
        </button>
      </form>
    </h3>

  </div>
  <table class="table-fill">

    <thead>

      <tr>
        <th class="text-left">Название
          <? if ($sort == "asc_title" and $column == "title") { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=title"><button>&#9650</button></a>
          <? } else { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=title"><button>&#9660</button></a>
          <? } ?>
        </th>
        <th width="12%" class="text-left">Фирма, модель
          <? if ($sort == "asc_title" and $column == "manufacturer") { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=manufacturer"><button>&#9650</button></a>
          <? } else { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=manufacturer"><button>&#9660</button></a>
          <? } ?>
        </th>
        <th width="7%" class="text-left">Сер. номер</th>
        <th width="11%" class="text-left">Дата покупки
          <? if ($sort == "asc_title" and $column == "date") { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=date"><button>&#9650</button></a>
          <? } else { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=date"><button>&#9660</button></a>
          <? } ?>
        </th>
        <th class="text-left">Гарантия до
          <? if ($sort == "asc_title" and $column == "guarantee_period") { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=guarantee_period"><button>&#9650</button></a>
          <? } else { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=guarantee_period"><button>&#9660</button></a>
          <? } ?>
        </th>
        <th width="10%" class="text-left">Стоимость
          <? if ($sort == "asc_title" and $column == "price") { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=desc_title&column=price"><button>&#9650</button></a>
          <? } else { ?>
            <a
              href="https://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=asc_title&column=price"><button>&#9660</button></a>
          <? } ?>
        </th>
        <th width="6%" class="text-left">Статус</th>
        <th width="8%" class="text-left">Мед. кабинет</th>


      </tr>
    </thead>
    <tbody class="table-hover">
      <?php


      if ($id_med_room != NULL and $search != NULL) {
        if ($sort == "asc_title") {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment`  WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%' ORDER BY `$column` ASC") or die(mysqli_error($connect));
        } elseif ($sort == "desc_title") {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment`  WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%' ORDER BY `$column` DESC") or die(mysqli_error($connect));
        } else {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment`  WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%'") or die(mysqli_error($connect));
        }
        $res = mysqli_query($connect, "SELECT SUM(`price`) FROM `equipment` WHERE `id_med_room`=$id_med_room AND `title` LIKE '%$search%'");
        $row = mysqli_fetch_row($res);
        $price = $row[0];
      } elseif ($search != NULL) {
        if ($sort == "asc_title") {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment`  WHERE `title` LIKE '%$search%' ORDER BY `$column` ASC") or die(mysqli_error($connect));
        } elseif ($sort == "desc_title") {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment`  WHERE `title` LIKE '%$search%' ORDER BY `$column` DESC") or die(mysqli_error($connect));
        } else {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment`  WHERE `title` LIKE '%$search%' ") or die(mysqli_error($connect));
        }
        $res = mysqli_query($connect, "SELECT SUM(`price`) FROM `equipment` WHERE `title` LIKE '%$search%'");
        $row = mysqli_fetch_row($res);
        $price = $row[0];
      } elseif ($id_med_room != NULL) {
        if ($sort == "asc_title") {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `id_med_room`=$id_med_room ORDER BY `$column` ASC") or die(mysqli_error($connect));
        } elseif ($sort == "desc_title") {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `id_med_room`=$id_med_room ORDER BY `$column` DESC") or die(mysqli_error($connect));
        } else {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `id_med_room`=$id_med_room ") or die(mysqli_error($connect));
        }
        $res = mysqli_query($connect, "SELECT SUM(`price`) FROM `equipment` WHERE `id_med_room`=$id_med_room");
        $row = mysqli_fetch_row($res);
        $price = $row[0];
      } else {
        if ($sort == "asc_title") {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment`  ORDER BY `$column` ASC") or die(mysqli_error($connect));
        } elseif ($sort == "desc_title") {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment`  ORDER BY `$column` DESC") or die(mysqli_error($connect));
        } else {
          $equipments = mysqli_query($connect, "SELECT * FROM `equipment` ") or die(mysqli_error($connect));
        }

        $res = mysqli_query($connect, "SELECT SUM(`price`) FROM `equipment`");
        $row = mysqli_fetch_row($res);
        $price = $row[0];
      }


      $equipments = mysqli_fetch_all($equipments);

      foreach ($equipments as $equipment) {
        $status = mysqli_query($connect, "SELECT * FROM `equipment_status` WHERE `id`='$equipment[8]'") or die(mysqli_error($connect));
        $status = mysqli_fetch_assoc($status);

        $med_room = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `id`='$equipment[9]'") or die(mysqli_error($connect));
        $med_room = mysqli_fetch_assoc($med_room);
        ?>

        <tr>

          <td class="text-left">
            <?= $equipment[1] ?>
          </td>
          <td class="text-left">
            <?= $equipment[2] ?>
            <?= $equipment[3] ?>
          </td>
          <td class="text-left">
            <?= $equipment[4] ?>
          </td>
          <td class="text-left">
            <?= $equipment[5] ?>
          </td>
          <?
          $now = new DateTime(date("Y/m/d"));
          $ref = new DateTime($equipment[6]);
          $diff = $now->diff($ref);
          $years = $diff->y;
          $months = $diff->m;
          $days = $diff->d;
          if ($now > $ref) {

            ?>
            <td  style="background-color: red;">
              Срок годности истек
            </td>
          <?
          } else {
            if ($years >= 1) {
              ?>
              <td  style="background-color: green;
                        color:white;">
                <?= $equipment[6] ?>
                (Осталось:
                <?=
                  $years . " г. " . $months . " мес. " . $days . " д."
                  ?>)
              </td>
            <? } elseif ($months >= 1) {
              ?>
              <td  style="background-color: green; color:white;">
                <?= $equipment[6] ?>
                (Осталось:
                <?=
                  $months . " мес. " . $days . " д."
                  ?>)
              </td>
            <? } else {
              ?>
              <td  style="background-color: orange; color:white;">
                <?= $equipment[6] ?>
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
            <?= $equipment[7] ?> Руб.
          </td>
          <td class="text-left">
            <?= $status['title'] ?>
          </td>
          <td class="text-left">
            <?= $med_room['title'] ?>
          </td>

        </tr>
        <?php
      }
      ?>
      <td colspan="6">Итого cумма:</td>
      <td>
        <?= $price ?> Руб.
      </td>
      <td>
        <a href="https://medin.bfuunit.ru/export_excel_equipment.php?id_med_room=<?= $id_med_room ?>&search=<?= $search ?>&sort=<?= $sort ?>&column=<?= $column ?>">Экспорт</a>
      </td>
    </tbody>
  </table>
</body>

</html>