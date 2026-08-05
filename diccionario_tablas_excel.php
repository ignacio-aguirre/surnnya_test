<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Codigo')
            ->setCellValue('B1', 'Descripcion')
            ->setCellValue('C1', 'Valor Item')
            ->setCellValue('D1', 'Descripcion Item');
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:D1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$reg=registros("select diccionario_tablas.codigo, diccionario_tablas.descripcion, tablas_semestrales.valor, tablas_semestrales.descripcion as dite 
 from tablas_semestrales 
 left join diccionario_tablas on diccionario_tablas.codigo=tablas_semestrales.tipo
 where diccionario_tablas.baja is null order by diccionario_tablas.descripcion, tablas_semestrales.valor");

$fl=1;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["codigo"])
            ->setCellValue('B'.ltrim((string)$fl), utf8_encode($r["descripcion"]))
            ->setCellValue('C'.ltrim((string)$fl), $r["valor"])
            ->setCellValue('D'.ltrim((string)$fl), utf8_encode($r["dite"]));
};

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'D'; $col++){
	ajusta($col);
};
$spreadsheet->getActiveSheet()->setTitle('Dic-tablas');
$filename = 'DiccionarioTablas.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;


function ajusta($r){
global $spreadsheet;
$spreadsheet->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
}


?>
           