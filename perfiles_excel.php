<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Perfiles de usuarios SURNNYA')
            ->setCellValue('A2', 'Nombre')
            ->setCellValue('B2', utf8_encode('Menú'))
            ->setCellValue('C2', 'Permiso')
            ->setCellValue('D2', 'Cant.Usuarios')
            ->setCellValue('E2', utf8_encode('Definición'))

  ;
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:E2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select perfiles.*, menues.nombre,(select count(*) from usuarios where perfil=perfiles.id and baja is null) as cantidad from perfiles left join menues on menu_nuevo=idmenues order by denominacion";
   $reg=registros($sql);
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["denominacion"])
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('C'.ltrim((string)$fl), permisos($r))
            ->setCellValue('D'.ltrim((string)$fl), $r["cantidad"])
            ->setCellValue('E'.ltrim((string)$fl), $r["definicion"])

 	    ;	
  };
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	



for($col='A'; $col<= 'E'; $col++){
	ajusta($col);
};



$spreadsheet->getActiveSheet()->setTitle('PerfilesSURNNYA');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'PerfilesSURNNYA.xlsx';

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
           