<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$desde=fget("desde");
$hasta=fget("hasta");

$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Dispositivo')
            ->setCellValue('B1', 'Egresados')
            ->setCellValue('C1', 'h/90 ds')
	    ->setCellValue('D1', '+90 h/180 ds')
            ->setCellValue('E1', '+180 ds')
            ->setCellValue('F1', 'Promedio');
 $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:F1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select nombre, count(*) as alojados, sum(case when datediff(admi_baja,admi_alta)<=90 then 1 else 0 end) as h90,
sum(case when datediff(admi_baja,admi_alta)>90 and datediff(admi_baja,admi_alta)<=180 then 1 else 0 end) as h180,
sum(case when datediff(admi_baja,admi_alta)>180 then 1 else 0 end) as hmas, avg(datediff(admi_baja,admi_alta)) as prom
from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar
 where admi_baja between ".$desde." and ".$hasta." and area_gubernamental=1 and tipo_dispositivo=11
 group by nombre order by nombre";
$reg=registros($sql);
$fl=1;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["alojados"])
            ->setCellValue('C'.ltrim((string)$fl), $r["h90"])
            ->setCellValue('D'.ltrim((string)$fl), $r["h180"])
            ->setCellValue('E'.ltrim((string)$fl), $r["hmas"])
            ->setCellValue('F'.ltrim((string)$fl), intval($r["prom"]))
;
};
$sql="select count(*) as alojados, sum(case when datediff(admi_baja,admi_alta)<=90 then 1 else 0 end) as h90,
sum(case when datediff(admi_baja,admi_alta)>90 and datediff(admi_baja,admi_alta)<=180 then 1 else 0 end) as h180,
sum(case when datediff(admi_baja,admi_alta)>180 then 1 else 0 end) as hmas, avg(datediff(admi_baja,admi_alta)) as prom
from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar
 where admi_baja between ".$desde." and ".$hasta." and area_gubernamental=1 and tipo_dispositivo=11";
$r=un_registro($sql);
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "TOTALES")
            ->setCellValue('B'.ltrim((string)$fl), $r["alojados"])
            ->setCellValue('C'.ltrim((string)$fl), $r["h90"])
            ->setCellValue('D'.ltrim((string)$fl), $r["h180"])
            ->setCellValue('E'.ltrim((string)$fl), $r["hmas"])
            ->setCellValue('F'.ltrim((string)$fl), intval($r["prom"]))
;


$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Fechas Desde/Hasta ".$_GET["desde"]." - ".$_GET["hasta"]);

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'F'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Permanencia');
$spreadsheet->setActiveSheetIndex(0);
$filename="Permanencia-egresos.xlsx";
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
           