<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Menues SURNNYA')
            ->setCellValue('A2', 'Nombre')
            ->setCellValue('B2', 'URL')
            ->setCellValue('C2', 'Cant.Usuarios')
  ;
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:D2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select menues.*, (select count(*) from usuarios where perfil in (select perfiles.id from perfiles where menu_nuevo=idmenues)) as cantidad from menues order by nombre";
   $reg=registros($sql);
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["descripcion"])
            ->setCellValue('C'.ltrim((string)$fl), $r["cantidad"])
 	    ;	
  };
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	



for($col='A'; $col<= 'D'; $col++){
	ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('MenuesSURNNYA');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'MenuesSURNNYA.xlsx';

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
           