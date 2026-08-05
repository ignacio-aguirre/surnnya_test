<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Visitas a dispositivos de cuidados alternativos'.utf8_encode(' año ').$_GET["anio"])
            ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'Enero')
            ->setCellValue('C2', 'Febrero')
            ->setCellValue('D2', 'Marzo')
            ->setCellValue('E2', 'Abril')
            ->setCellValue('F2', 'Mayo')
            ->setCellValue('G2', 'Junio')
            ->setCellValue('H2', 'Julio')
            ->setCellValue('I2', 'Agosto')
            ->setCellValue('J2', 'Septiembre')
            ->setCellValue('K2', 'Octubre')
            ->setCellValue('L2', 'Noviembre')
            ->setCellValue('M2', 'Diciembre')
            ->setCellValue('N2', utf8_encode('Año'))
;
$sql="select nombre,
 sum(case when month(super_fecha)=1 then 1 else 0 end) as enero,
 sum(case when month(super_fecha)=2 then 1 else 0 end) as febrero,
 sum(case when month(super_fecha)=3 then 1 else 0 end) as marzo,
 sum(case when month(super_fecha)=4 then 1 else 0 end) as abril,
 sum(case when month(super_fecha)=5 then 1 else 0 end) as mayo,
 sum(case when month(super_fecha)=6 then 1 else 0 end) as junio,
 sum(case when month(super_fecha)=7 then 1 else 0 end) as julio,
 sum(case when month(super_fecha)=8 then 1 else 0 end) as agosto,
 sum(case when month(super_fecha)=9 then 1 else 0 end) as septiembre,
 sum(case when month(super_fecha)=10 then 1 else 0 end) as octubre,
 sum(case when month(super_fecha)=11 then 1 else 0 end) as noviembre,
 sum(case when month(super_fecha)=12 then 1 else 0 end) as diciembre,
 count(*) as tot 
 from super_visita left join dispositivos on super_hogar=dispositivos.id
 where year(super_fecha)=".$_GET["anio"]." and tipo_dispositivo".si($_GET["tipo"]==1,"<>1","=1")." group by nombre order by nombre"; 
$reg=registros($sql);
$fl=2;

$enero=0;
$febrero=0;
$marzo=0;
$abril=0;
$mayo=0;
$junio=0;
$julio=0;
$agosto=0;
$septiembre=0;
$octubre=0;
$noviembre=0;
$diciembre=0;
$tot=0;

 
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["enero"])
            ->setCellValue('C'.ltrim((string)$fl), $r["febrero"])
            ->setCellValue('D'.ltrim((string)$fl), $r["marzo"])
            ->setCellValue('E'.ltrim((string)$fl), $r["abril"])
            ->setCellValue('F'.ltrim((string)$fl), $r["mayo"])
            ->setCellValue('G'.ltrim((string)$fl), $r["junio"])
            ->setCellValue('H'.ltrim((string)$fl), $r["julio"])
            ->setCellValue('I'.ltrim((string)$fl), $r["agosto"])
            ->setCellValue('J'.ltrim((string)$fl), $r["septiembre"])
            ->setCellValue('K'.ltrim((string)$fl), $r["octubre"])
            ->setCellValue('L'.ltrim((string)$fl), $r["noviembre"])
            ->setCellValue('M'.ltrim((string)$fl), $r["diciembre"])
            ->setCellValue('N'.ltrim((string)$fl), $r["tot"]);
 $enero=$enero+$r["enero"];
 $febrero=$febrero+$r["febrero"];
 $marzo=$marzo+$r["marzo"];
 $abril=$abril+$r["abril"];
 $mayo=$mayo+$r["mayo"];
 $junio=$junio+$r["junio"];
 $julio=$julio+$r["julio"];
 $agosto=$agosto+$r["agosto"];
 $septiembre=$septiembre+$r["septiembre"];
 $octubre=$octubre+$r["octubre"];
 $noviembre=$noviembre+$r["noviembre"];
 $diciembre=$diciembre+$r["diciembre"];
 $tot=$tot+$r["tot"];


};
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "T O T A L E S")
            ->setCellValue('B'.ltrim((string)$fl), $enero)
            ->setCellValue('C'.ltrim((string)$fl), $febrero)
            ->setCellValue('D'.ltrim((string)$fl), $marzo)
            ->setCellValue('E'.ltrim((string)$fl), $abril)
            ->setCellValue('F'.ltrim((string)$fl), $mayo)
            ->setCellValue('G'.ltrim((string)$fl), $junio)
            ->setCellValue('H'.ltrim((string)$fl), $julio)
            ->setCellValue('I'.ltrim((string)$fl), $agosto)
            ->setCellValue('J'.ltrim((string)$fl), $septiembre)
            ->setCellValue('K'.ltrim((string)$fl), $octubre)
            ->setCellValue('L'.ltrim((string)$fl), $noviembre)
            ->setCellValue('M'.ltrim((string)$fl), $diciembre)
            ->setCellValue('N'.ltrim((string)$fl), $tot);
$spreadsheet->setActiveSheetIndex(0)->getStyle("A1:N2")->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$spreadsheet->setActiveSheetIndex(0)->getStyle("A".ltrim((string)$fl).":N".ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'Z'; $col++){
	ajusta($col);
};



$spreadsheet->getActiveSheet()->setTitle('Visitas');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Visitas.xlsx';

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