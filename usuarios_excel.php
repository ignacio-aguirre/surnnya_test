<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new  Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Apellido y Nombre')
            ->setCellValue('B1', 'CUIL')
            ->setCellValue('C1', 'Sector')
            ->setCellValue('D1', 'Rol')
	    ->setCellValue('E1', 'Email registrado en SURNNYA')
  ;
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:E1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select apellido, usuarios.nombre, cuil, sectores.denominacion as ndispo, perfiles.denominacion as nperfil, usuarios.email, intentos from usuarios 
       left outer join sectores on sector=sectores.id
       left outer join perfiles on perfil=perfiles.id
       where usuarios.baja is null order by apellido, usuarios.nombre";
   $reg=registros($sql);
   $fl=1;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["apellido"]." , ".$r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["cuil"])
            ->setCellValue('C'.ltrim((string)$fl), $r["ndispo"])
 	    ->setCellValue('D'.ltrim((string)$fl), $r["nperfil"])	
 	    ->setCellValue('E'.ltrim((string)$fl), $r["email"])	
 	    ;	
  };
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	



for($col='A'; $col<= 'E'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('UsuariosSURNNYA');
$spreadsheet->setActiveSheetIndex(0);

$filename = 'UsuariosSURNNYA.xlsx';

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
           