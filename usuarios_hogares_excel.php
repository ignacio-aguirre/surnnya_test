<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Dispositivo')
            ->setCellValue('B1', 'Apellidos y Nombres')
            ->setCellValue('C1', 'DNI')
            ->setCellValue('D1', 'Profesion')
            ->setCellValue('E1', 'Matricula')
            ->setCellValue('F1', 'Funcion')
            ->setCellValue('G1', 'Firma')
            ->setCellValue('H1', 'Email')
            ->setCellValue('I1', 'Usuario')
            ->setCellValue('J1', 'Multihogar')
	    ->setCellValue('K1', 'Perfil Moviles');
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:K1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$reg=registros("select usuarios_hogares.*, nombre from usuarios_hogares 
 left join dispositivos on hogar=dispositivos.id
 where usuarios_hogares.baja is null order by nombre, apellidos, nombres");

$fl=1;

while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["apellidos"]." , ".$r["nombres"])
            ->setCellValue('C'.ltrim((string)$fl), $r["dni"])
            ->setCellValue('D'.ltrim((string)$fl), $r["profesion"])
            ->setCellValue('E'.ltrim((string)$fl), $r["matricula"])
            ->setCellValue('G'.ltrim((string)$fl), si($r["firma"]=="1","SI","NO"))
            ->setCellValue('H'.ltrim((string)$fl), $r["email"])
            ->setCellValue('I'.ltrim((string)$fl), $r["descripcion"])
            ->setCellValue('J'.ltrim((string)$fl), si($r["es_multihogar"]=="1","SI","NO"))
            ->setCellValue('K'.ltrim((string)$fl), $r["perfil_moviles"]);
 if($r["es_multihogar"]=="1"){
   $mul=registros("select nombre, funcion from usuarios_hogares_roles 
   left join dispositivos on hogar=dispositivos.id where usuario=".$r["id"]." order by nombre");
   $fl=$fl-1;
   while($m=mysqli_fetch_assoc($mul)){
     $fl=$fl+1;
     $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.ltrim((string)$fl), $m["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["apellidos"]." , ".$r["nombres"])
     ->setCellValue('F'.ltrim((string)$fl), $m["funcion"]);
   };
 }
 else{$spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.ltrim((string)$fl), $r["funcion"]);};
};



$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'K'; $col++){
	ajusta($col);
};
$spreadsheet->getActiveSheet()->setTitle('Usuarios de Hogares');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Usuarios-hogares.xlsx';

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
           