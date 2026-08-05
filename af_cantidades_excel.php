<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Pertenencia')
            ->setCellValue('B1', 'Dispositivo')
            ->setCellValue('C1', 'NNYA')
   ;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:C1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$fech=fsql($_GET["fecha"]);
$sql="select case when ong>0 then 'CONVENIADOS' else 'PROPIOS' end as perte, nombre,count(*) as cantidad 
    from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo
    left join dispositivos on admi_hogar=dispositivos.id
    where tipo_dispositivo=1 and  admi_alta <=".$fech." and (admi_baja is null or admi_baja>".$fech.")
    group by perte, nombre
    order by perte, nombre";

$reg=registros($sql);
$tot=0;
$propios=0;
$conveniados=0;
$fl=1;
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["perte"])
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
 	    ->setCellValue('C'.ltrim((string)$fl), $r["cantidad"])
    ;	
 if($r["perte"]=="PROPIOS"){$propios=$propios+$r["cantidad"];};
 if($r["perte"]=="CONVENIADOS"){$conveniados=$conveniados+$r["cantidad"];};
 $tot=$tot+$r["cantidad"];

};



 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B'.ltrim((string)$fl), "TOTAL")
            ->setCellValue('C'.ltrim((string)$fl), $tot)
	    ;
$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Pertenencia")
            ->setCellValue('C'.ltrim((string)$fl), "NNYA");
$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "PROPIOS")
            ->setCellValue('C'.ltrim((string)$fl), $propios);
$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "CONVENIADOS")
            ->setCellValue('C'.ltrim((string)$fl), $conveniados);
	
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Fecha Referencia ".$_GET["fecha"]);
	
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),utf8_encode("Usuario ".$_SESSION["glusua"]));
	

for($col='A'; $col<= 'C'; $col++){
	ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('CntSAFT');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'SAFT-cantidades.xlsx';

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
};


?>
           