<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Actividades en Visitas a '.si($_GET["tipo"]==1,"hogares","dispositivos de acogimiento familiar"))
            ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'Visitas')
            ->setCellValue('C2', 'Entrevistas')
            ->setCellValue('D2', utf8_encode('Obs.Dinámicas Convivenciales'))
            ->setCellValue('E2', 'Talleres con NNYA')
            ->setCellValue('F2', utf8_encode('Propuestas Lúdicas'))
            ->setCellValue('G2', utf8_encode('Participación en Actividades'))
            ->setCellValue('H2', 'Otros')
;
$spreadsheet->setActiveSheetIndex(0)->getStyle("A1:H2")->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select nombre,
 sum(acti_entrevista) as acti_ent,
 sum(acti_obs_dinamicas) as acti_obs,
 sum(acti_talleres) as acti_tal,
 sum(acti_ludicas) as acti_lud,
 sum(acti_participacion) as acti_par,
 sum(acti_otros) as acti_otr,
 count(*) as tot 
from super_visita left join dispositivos on super_hogar=dispositivos.id
 where super_fecha between ".fsql($_GET["desde"])." and ".fsql($_GET["hasta"])." and tipo_dispositivo".si($_GET["tipo"]==1,"<>1","=1")." group by nombre order by nombre"; 
$reg=registros($sql);
$fl=2;
$ent=0;
$obs=0;
$tal=0;
$lud=0;
$par=0;
$otr=0;
$tot=0;
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["tot"])
            ->setCellValue('C'.ltrim((string)$fl), $r["acti_ent"])
            ->setCellValue('D'.ltrim((string)$fl), $r["acti_obs"])
            ->setCellValue('E'.ltrim((string)$fl), $r["acti_tal"])
            ->setCellValue('F'.ltrim((string)$fl), $r["acti_lud"])
            ->setCellValue('G'.ltrim((string)$fl), $r["acti_par"])
            ->setCellValue('H'.ltrim((string)$fl), $r["acti_otr"])
;
 $ent=$ent+$r["acti_ent"];
 $obs=$obs+$r["acti_obs"];
 $tal=$tal+$r["acti_tal"];
 $lud=$lud+$r["acti_lud"];
 $par=$par+$r["acti_par"];
 $otr=$otr+$r["acti_otr"];
 $tot=$tot+$r["tot"];

};


$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "T O T A L E S")
            ->setCellValue('B'.ltrim((string)$fl), $tot)
            ->setCellValue('C'.ltrim((string)$fl), $ent)
            ->setCellValue('D'.ltrim((string)$fl), $obs)
            ->setCellValue('E'.ltrim((string)$fl), $tal)
            ->setCellValue('F'.ltrim((string)$fl), $lud)
            ->setCellValue('G'.ltrim((string)$fl), $par)
            ->setCellValue('H'.ltrim((string)$fl), $otr)
;


$spreadsheet->setActiveSheetIndex(0)->getStyle("A".ltrim((string)$fl).":H".ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

for($col='A'; $col<= 'H'; $col++){
	ajusta($col);
};

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Desde ".$_GET["desde"]." / Hasta ".$_GET["hasta"]);
$fl=$fl+2;
 $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);


$spreadsheet->getActiveSheet()->setTitle('ActividadesVisitas');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Actividades-visitas.xlsx';

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