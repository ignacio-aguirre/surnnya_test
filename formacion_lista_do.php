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
	    ->setCellValue('D1', utf8_encode('Internos'))
	    ->setCellValue('K1', utf8_encode('Externos'))
            ->setCellValue('A2', 'Fecha')
	    ->setCellValue('B2', 'Dispositivo')
            ->setCellValue('C2', utf8_encode('Descripción'))
            ->setCellValue('D2', 'Total')
            ->setCellValue('E2', 'R.Equipo')
            ->setCellValue('F2', 'Talleres')
            ->setCellValue('G2', 'M.Trabajo')
            ->setCellValue('H2', 'Capacitaciones')
            ->setCellValue('I2', 'Asambleas')
            ->setCellValue('J2', 'Otros')
            ->setCellValue('K2', 'Total')
            ->setCellValue('L2', 'Capacitaciones')
            ->setCellValue('M2', 'Jornadas')
            ->setCellValue('N2', utf8_encode('S.Técnica'))
            ->setCellValue('O2', 'Otros')
;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:O2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select super_fecha,nombre,fore_detalle,
 inte_reuniones+inte_talleres+inte_mesas+inte_capacitaciones+inte_asambleas+inte_otros as inte_tot,
 inte_reuniones as inte_reu,
 inte_talleres as inte_tal,
 inte_mesas as inte_mes,
 inte_capacitaciones as inte_cap,
 inte_asambleas as inte_asa,
 inte_otros as inte_otr,
 exte_capacitaciones+exte_jornadas+exte_supervision+exte_otros as exte_tot,
 exte_capacitaciones as exte_cap,
 exte_jornadas as exte_jor,
 exte_supervision as exte_sup,
 exte_otros as exte_otr 
from super_visita left join dispositivos on super_hogar=dispositivos.id
 where super_fecha between ".fsql($_GET["desde"])." and ".fsql($_GET["hasta"])." and tipo_dispositivo".si($_GET["tipo"]==1,"<>1","=1")." order by super_fecha"; 
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
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["super_fecha"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('C'.ltrim((string)$fl), $r["fore_detalle"])
            ->setCellValue('D'.ltrim((string)$fl), $r["inte_tot"])
            ->setCellValue('E'.ltrim((string)$fl), $r["inte_reu"])
            ->setCellValue('F'.ltrim((string)$fl), $r["inte_tal"])
            ->setCellValue('G'.ltrim((string)$fl), $r["inte_mes"])
            ->setCellValue('H'.ltrim((string)$fl), $r["inte_cap"])
	    ->setCellValue('I'.ltrim((string)$fl), $r["inte_asa"])
	    ->setCellValue('J'.ltrim((string)$fl), $r["inte_otr"])
	    ->setCellValue('K'.ltrim((string)$fl), $r["exte_tot"])
	    ->setCellValue('L'.ltrim((string)$fl), $r["exte_cap"])
	    ->setCellValue('M'.ltrim((string)$fl), $r["exte_jor"])
	    ->setCellValue('N'.ltrim((string)$fl), $r["exte_sup"])
	    ->setCellValue('O'.ltrim((string)$fl), $r["exte_otr"])
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
 $tot=$tot+1;

};


$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "T O T A L E S")
            ->setCellValue('B'.ltrim((string)$fl), $tot)
            ->setCellValue('D'.ltrim((string)$fl), $itot)
            ->setCellValue('E'.ltrim((string)$fl), $ireu)
            ->setCellValue('F'.ltrim((string)$fl), $ital)
            ->setCellValue('G'.ltrim((string)$fl), $imes)
            ->setCellValue('H'.ltrim((string)$fl), $icap)
	    ->setCellValue('I'.ltrim((string)$fl), $iasa)
	    ->setCellValue('J'.ltrim((string)$fl), $iotr)
	    ->setCellValue('K'.ltrim((string)$fl), $etot)
	    ->setCellValue('L'.ltrim((string)$fl), $ecap)
	    ->setCellValue('M'.ltrim((string)$fl), $ejor)
	    ->setCellValue('N'.ltrim((string)$fl), $esup)
	    ->setCellValue('O'.ltrim((string)$fl), $eotr)
;

for($col='B'; $col<= 'B'; $col++){
	ajusta($col);
};

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Desde ".$_GET["desde"]." / Hasta ".$_GET["hasta"]);
$fl=$fl+2;
 $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);


$spreadsheet->getActiveSheet()->setTitle('FormacionEquiposLista');
$spreadsheet->setActiveSheetIndex(0);
$filename="Formacion-lista.xlsx";
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