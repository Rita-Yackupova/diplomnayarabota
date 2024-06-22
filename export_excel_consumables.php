<?
require_once 'Classes/PHPExcel.php';
require_once 'connect.php';

$search = $_GET['search'];
$id_med_room = $_GET['id_med_room'];
$sort = $_GET['sort'];
$column = $_GET['column'];

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$active_sheet = $objPHPExcel->getActiveSheet();

$active_sheet->getColumnDimension('A')->setWidth(15);
$active_sheet->getColumnDimension('B')->setWidth(15);
$active_sheet->getColumnDimension('C')->setWidth(15);
$active_sheet->getColumnDimension('D')->setWidth(15);
$active_sheet->getColumnDimension('E')->setWidth(15);
$active_sheet->getColumnDimension('F')->setWidth(15);

$active_sheet->mergeCells('A1:F1');
$active_sheet->setCellValue('A1', 'Расходные материалы');
$active_sheet->setCellValue('A2', 'Название');
$active_sheet->setCellValue('B2', 'Количество');
$active_sheet->setCellValue('C2', 'Дата покупки');
$active_sheet->setCellValue('D2', 'Срок годности до');
$active_sheet->setCellValue('E2', 'Стоимость');
$active_sheet->setCellValue('F2', 'Мед. кабинет');

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

$i = 3;

foreach ($consumables as $consumable) {

    $med_room = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `id`='$consumable[6]'") or die(mysqli_error($connect));
    $med_room = mysqli_fetch_assoc($med_room);

    $active_sheet->setCellValue('A' . $i, $consumable[1]);
    $active_sheet->setCellValue('B' . $i, $consumable[2]);
    $active_sheet->setCellValue('C' . $i, $consumable[3]);
    $active_sheet->setCellValue('D' . $i, $consumable[4]);
    $active_sheet->setCellValue('E' . $i, $consumable[5]);
    $active_sheet->setCellValue('F' . $i, $med_room['title']);

    $i++;
}
$active_sheet->setCellValue('A' . $i, 'Итого:');
$active_sheet->setCellValue('B' . $i, $amount);
$active_sheet->setCellValue('D' . $i, 'Сумма:');
$active_sheet->setCellValue('E' . $i, $price);

header('Content-Type:xlsx:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition:attachment;filename="Расходные материалы.xlsx"');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');

if ($id_med_room != NULL) {
    header("Location: http://medin.bfuunit.ru/consumables_list.php?id_med_room=<?= $med_room[0] ?>");
} else {
    header("Location: http://medin.bfuunit.ru/consumables_list.php");
}
