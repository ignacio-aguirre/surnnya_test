<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', utf8_encode('Espacios de Formación y Reflexión de Equipos en ').si($_GET["tipo"]==1,"hogares","dispositivos de acogimiento familiar"))
	    ->setCellValue('C1', utf8_encode('Internos'))
	    ->setCellValue('J1', utf8_encode('Externos'))
	    ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'Visitas')
            ->setCellValue('C2', 'Total')
            ->setCellValue('D2', 'R.Equipo')
            ->setCellValue('E2', 'Talleres')
            ->setCellValue('F2', 'M.Trabajo')
            ->setCellValue('G2', 'Capacitaciones')
            ->setCellValue('H2', 'Asambleas')
            ->setCellValue('I2', 'Otros')
            ->setCellValue('J2', 'Total')
            ->setCellValue('K2', 'Capacitaciones')
            ->setCellValue('L2', 'Jornadas')
            ->setCellValue('M2', utf8_encode('S.Técnica'))
            ->setCellValue('N2', 'Otros')
;
$sql="select nombre,
 sum(inte_reuniones+inte_talleres+inte_mesas+inte_capacitaciones+inte_asambleas+inte_otros) as inte_tot,
 sum(inte_reuniones) as inte_reu,
 sum(inte_talleres) as inte_tal,
 sum(inte_mesas) as inte_mes,
 sum(inte_capacitaciones) as inte_cap,
 sum(inte_asambleas) as inte_asa,
 sum(inte_otros) as inte_otr,
 sum(exte_capacitaciones+exte_jornadas+exte_supervision+exte_otros) as exte_tot,
 sum(exte_capacitaciones) as exte_cap,
 sum(exte_jornadas) as exte_jor,
 sum(exte_supervision) as exte_sup,
 sum(exte_otros) as exte_otr,
 count(*) as tot 
from super_visita left join dispositivos on super_hogar=dispositivos.id
 where super_fecha between ".fsql($_GET["desde"])." and ".fsql($_GET["hasta"])." and tipo_dispositivo".si($_GET["tipo"]==1,"<>1","=1")." group by nombre order by nombre"; 
$reg=registros($sql);
$fl=2;
$itot=0;
$ireu=0;
$ital=0;
$imes=0;
$icap=0;
$iasa=0;
$iotr=0;
$etot=0;
$ecap=0;
$ejor=0;
$esup=0;
$eotr=0;
$tot=0;
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["tot"])
            ->setCellValue('C'.ltrim((string)$fl), $r["inte_tot"])
            ->setCellValue('D'.ltrim((string)$fl), $r["inte_reu"])
            ->setCellValue('E'.ltrim((string)$fl), $r["inte_tal"])
            ->setCellValue('F'.ltrim((string)$fl), $r["inte_mes"])
            ->setCellValue('G'.ltrim((string)$fl), $r["inte_cap"])
	    ->setCellValue('H'.ltrim((string)$fl), $r["inte_asa"])
	    ->setCellValue('I'.ltrim((string)$fl), $r["inte_otr"])
	    ->setCellValue('J'.ltrim((string)$fl), $r["exte_tot"])
	    ->setCellValue('K'.ltrim((string)$fl), $r["exte_cap"])
	    ->setCellValue('L'.ltrim((string)$fl), $r["exte_jor"])
	    ->setCellValue('M'.ltrim((string)$fl), $r["exte_sup"])
	    ->setCellValue('N'.ltrim((string)$fl), $r["exte_otr"])
;
 $itot=$itot+$r["inte_tot"];
 $ireu=$ireu+$r["inte_reu"];
 $ital=$ital+$r["inte_tal"];
 $imes=$imes+$r["inte_mes"];
 $icap=$icap+$r["inte_cap"];
 $iasa=$iasa+$r["inte_asa"];
 $iotr=$iotr+$r["inte_otr"];
 $etot=$etot+$r["exte_tot"];
 $ecap=$ecap+$r["exte_cap"];
 $ejor=$ejor+$r["exte_jor"];
 $esup=$esup+$r["exte_sup"];
 $eotr=$eotr+$r["expe_otr"];
 $tot=$tot+$r["tot"];

};


$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "T O T A L E S")
            ->setCellValue('B'.ltrim((string)$fl), $tot)
            ->setCellValue('C'.ltrim((string)$fl), $itot)
            ->setCellValue('D'.ltrim((string)$fl), $ireu)
            ->setCellValue('E'.ltrim((string)$fl), $ital)
            ->setCellValue('F'.ltrim((string)$fl), $imes)
            ->setCellValue('G'.ltrim((string)$fl), $icap)
	    ->setCellValue('H'.ltrim((string)$fl), $iasa)
	    ->setCellValue('I'.ltrim((string)$fl), $iotr)
	    ->setCellValue('J'.ltrim((string)$fl), $etot)
	    ->setCellValue('K'.ltrim((string)$fl), $ecap)
	    ->setCellValue('L'.ltrim((string)$fl), $ejor)
	    ->setCellValue('M'.ltrim((string)$fl), $esup)
	    ->setCellValue('N'.ltrim((string)$fl), $eotr)
;
$auf=ltrim((string)($fl-1));
$spreadsheet->setActiveSheetIndex(0)->getStyle("A1:B".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$spreadsheet->setActiveSheetIndex(0)->getStyle("C1:I".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('C4F7B3');

$spreadsheet->setActiveSheetIndex(0)->getStyle("J1:N".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('F5CA42');

$spreadsheet->setActiveSheetIndex(0)->getStyle("A".ltrim((string)$fl).":N".ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


for($col='A'; $col<= 'B'; $col++){
	ajusta($col);
};

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Desde ".$_GET["desde"]." / Hasta ".$_GET["hasta"]);
$fl=$fl+2;
 $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);


$spreadsheet->getActiveSheet()->setTitle('FormacionEquipos');
$filename = 'FormacionEquipos.xlsx';

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