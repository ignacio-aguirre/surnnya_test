<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Sectores CDNNYA en SURNNYA')
            ->setCellValue('A2', 'Id')
            ->setCellValue('B2', 'Nombre')
            ->setCellValue('C2', 'Cant.Usuarios')
  ;
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:C2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select sectores.id,sectores.denominacion, (select count(*) from usuarios where sector=sectores.id) as cantidad from sectores where baja is null order by denominacion";
   $reg=registros($sql);
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["id"])
            ->setCellValue('B'.ltrim((string)$fl), $r["denominacion"])
            ->setCellValue('C'.ltrim((string)$fl), $r["cantidad"])
 	    ;	
  };
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	



for($col='B'; $col<= 'D'; $col++){
	ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('SectoresSURNNYA');
$filename = 'SectoresSURNNYA.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

 function permisos($r){
  $t=si($r["soloconsulta"]=="1","CONSULTA",si($r["menu_nuevo"]=="","NINGUNO","CARGA"));
  return $t;
 };

function ajusta($r){
global $spreadsheet;
$spreadsheet->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
};
?>
           