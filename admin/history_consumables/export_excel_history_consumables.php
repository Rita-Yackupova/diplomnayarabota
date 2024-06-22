<?
session_start();

if (!$_SESSION['admin']) {
  header('Location:/admin/index.php');
}

require_once '../../Classes/PHPExcel.php';
require_once '../php/connect.php';

$search = $_GET['search'];
$id_med_room = $_GET['id_med_room'];
$start = $_GET['start'];
$end = $_GET['end'];

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$active_sheet = $objPHPExcel->getActiveSheet();

$active_sheet->getColumnDimension('A')->setWidth(15);
$active_sheet->getColumnDimension('B')->setWidth(15);
$active_sheet->getColumnDimension('C')->setWidth(15);
$active_sheet->getColumnDimension('D')->setWidth(20);
$active_sheet->getColumnDimension('E')->setWidth(20);
$active_sheet->getColumnDimension('F')->setWidth(20);

$active_sheet->mergeCells('A1:E1');
$active_sheet->setCellValue('A1', 'История расходных материалов');
$active_sheet->setCellValue('A2', 'Действие');
$active_sheet->setCellValue('B2', 'Название');
$active_sheet->setCellValue('C2', 'Количество');
$active_sheet->setCellValue('D2', 'Кем выполнено');
$active_sheet->setCellValue('E2', 'Дата и время');
$active_sheet->setCellValue('F2', 'Мед. кабинет');


if ($id_med_room != NULL) {
    if ($search != NULL and $start != NULL and $end != NULL) {

        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE `id_med_room`=$id_med_room AND (`date` >= '$start' AND `date` <='$end')  AND (`title` LIKE '%$search%' OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
    } elseif ($search != NULL and $start != NULL) {
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
WHERE `id_med_room`=$id_med_room AND  `title` LIKE '%$search%'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
    } else {
        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables` WHERE `id_med_room`=$id_med_room ORDER BY `date` DESC  ") or die(mysqli_error($connect));
    }
} else {
    if ($search != NULL and $start != NULL and $end != NULL) {

        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables`  
WHERE (`date` >= '$start' AND `date` <='$end')  AND (`title` LIKE '%$search%' OR `action`  LIKE '%$search%')
ORDER BY `date` DESC ") or die(mysqli_error($connect));
    } elseif ($search != NULL and $start != NULL) {
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
WHERE `title` LIKE '%$search%'
ORDER BY `date` DESC ") or die(mysqli_error($connect));
    } else {
        $history_consumables = mysqli_query($connect, "SELECT * FROM `history_consumables` ORDER BY `date` DESC  ") or die(mysqli_error($connect));
    }
}

$history_consumables = mysqli_fetch_all($history_consumables);

$i = 3;

foreach ($history_consumables as $history_consumable) {

    $med_rooms = mysqli_query($connect, "SELECT * FROM `med_room` WHERE `id`='$history_consumable[6]'") or die(mysqli_error($connect));
    $med_rooms = mysqli_fetch_assoc($med_rooms);

    $admins = mysqli_query($connect, "SELECT * FROM `admins` WHERE `id`='$history_consumable[5]'") or die(mysqli_error($connect));
    $admins = mysqli_fetch_assoc($admins);

    $role = mysqli_query($connect, "SELECT * FROM `roles` WHERE `id`='$admins[id_role]'") or die(mysqli_error($connect));
    $role = mysqli_fetch_assoc($role);


    $active_sheet->setCellValue('A' . $i, $history_consumable[2]);
    $active_sheet->setCellValue('B' . $i, $history_consumable[1]);
    $active_sheet->setCellValue('C' . $i, $history_consumable[3]);
    $active_sheet->setCellValue('D' . $i, $admins['name']);
    $active_sheet->setCellValue('E' . $i, $history_consumable[7]);
    $active_sheet->setCellValue('F' . $i, $med_rooms['title']);

    $i++;
}

header('Content-Type:xlsx:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition:attachment;filename="Оборудование.xlsx"');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');


header('Location: ' . $_SERVER['HTTP_REFERER']);
