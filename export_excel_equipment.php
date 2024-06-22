<?
require_once 'Classes/PHPExcel.php';
require_once 'connect.php';

$id_med_room = $_GET['id_med_room'];

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$active_sheet = $objPHPExcel->getActiveSheet();

$active_sheet->getColumnDimension('A')->setWidth(15);
$active_sheet->getColumnDimension('B')->setWidth(15);
$active_sheet->getColumnDimension('C')->setWidth(15);
$active_sheet->getColumnDimension('D')->setWidth(15);
$active_sheet->getColumnDimension('E')->setWidth(15);
$active_sheet->getColumnDimension('F')->setWidth(15);
$active_sheet->getColumnDimension('G')->setWidth(15);
$active_sheet->getColumnDimension('H')->setWidth(15);
$active_sheet->getColumnDimension('I')->setWidth(15);

$active_sheet->mergeCells('A1:I1');
$active_sheet->setCellValue('A1', 'Оборудование');
$active_sheet->setCellValue('A2', 'Название');
$active_sheet->setCellValue('B2', 'Фирма');
$active_sheet->setCellValue('C2', 'Модель');
$active_sheet->setCellValue('D2', 'Сер. номер');
$active_sheet->setCellValue('E2', 'Дата покупки');
$active_sheet->setCellValue('F2', 'Гарантия до');
$active_sheet->setCellValue('G2', 'Стоимость');
$active_sheet->setCellValue('H2', 'Статус');
$active_sheet->setCellValue('I2', 'Мед. кабинет');


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

$i = 3;

foreach ($equipments as $equipment) {
    $status = mysqli_query($connect, "SELECT * FROM `equipment_status` WHERE `id`='$equipment[8]'") or die(mysqli_error($connect));
    $status = mysqli_fetch_assoc($status);

    $med_room = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `id`='$equipment[9]'") or die(mysqli_error($connect));
    $med_room = mysqli_fetch_assoc($med_room);

    $active_sheet->setCellValue('A' . $i, $equipment[1]);
    $active_sheet->setCellValue('B' . $i, $equipment[2]);
    $active_sheet->setCellValue('C' . $i, $equipment[3]);
    $active_sheet->setCellValue('D' . $i, $equipment[4]);
    $active_sheet->setCellValue('E' . $i, $equipment[5]);
    $active_sheet->setCellValue('F' . $i, $equipment[6]);
    $active_sheet->setCellValue('G' . $i, $equipment[7]);
    $active_sheet->setCellValue('H' . $i, $status['title']);
    $active_sheet->setCellValue('I' . $i, $med_room['title']);

    $i++;
}

$active_sheet->setCellValue('F' . $i, 'Сумма:');
$active_sheet->setCellValue('G' . $i, $price);

header('Content-Type:xlsx:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition:attachment;filename="Оборудование.xlsx"');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');

if ($id_med_room != NULL) {
    header("Location: http://medin.bfuunit.ru/equipment_list.php?id_med_room=<?= $med_room[0] ?>");
} else {
    header("Location: http://medin.bfuunit.ru/equipment_list.php");
}
