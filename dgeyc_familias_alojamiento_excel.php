<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Dispositivo')
            ->setCellValue('B1', 'Familia')
            ->setCellValue('C1', 'NNYA Alojados')
            ->setCellValue('D1', 'Adultos GFC')
            ->setCellValue('E1', 'NNYA GFC')
;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:E1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select nombre, denominacion,
(select count(*) from hogares_admision where admi_fami=idaf_familias and admi_alta<=".fget("hasta")." and ( admi_baja>".fget("desde")." or admi_baja is null)) as alojados,
(select sum(case when edadcalc(fecha_nacimiento,edad,0,fecha_actualizacion,".fget("hasta").")>17 then 1 else 0 end) from personas where familia_pertenencia=idaf_familias) as adultos,
(select sum(case when edadcalc(fecha_nacimiento,edad,0,fecha_actualizacion,".fget("hasta").")<=17 then 1 else 0 end) from personas where familia_pertenencia=idaf_familias) as ninios 
 from af_familias left join dispositivos on hogar=dispositivos.id having alojados>0 order by nombre";
$reg=registros($sql);
$fl=1;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["denominacion"])
            ->setCellValue('C'.ltrim((string)$fl), $r["alojados"])
            ->setCellValue('D'.ltrim((string)$fl), $r["adultos"])
            ->setCellValue('E'.ltrim((string)$fl), $r["ninios"])


;
};
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Edades calculadas al ".$_GET["hasta"]);	

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
	->setCellValue('A'.ltrim((string)($fl+2)),"Fechas Desde / Hasta ".$_GET["desde"]." - ".$_GET["hasta"]);
for($col='A'; $col<= 'Z'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Familias');
$filename = 'SAFT-familias.xlsx';

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
           