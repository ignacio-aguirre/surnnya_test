<?php
// error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Reportes SURNNYA')
      ->setCellValue('A2', 'id Reporte')
      ->setCellValue('B2', 'Nombre en Reporte')
      ->setCellValue('C2', utf8_encode('Nombre en Men�'))
      ->setCellValue('D2', 'URL Principal')
      ->setCellValue('E2', 'Excel')
      ->setCellValue('F2', utf8_encode('Men�es que lo incluyen'))
      ->setCellValue('G2', utf8_encode('Definici�n Operativa'))
      ->setCellValue('H2', 'Roles que lo incluyen')
;
$sql="select * from reportes order by id";
$reg=registros($sql);
$fl=2;
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
  $menues="";
  $roles="";
  $men=registros("select distinct nombre,menu from menues_contenido left join menues on menu=idmenues where url=".tsql($r['url_principal']));
  while($m=mysqli_fetch_assoc($men)){
   $menues=$menues.$m["nombre"]." / ";
   $rols=registros("select denominacion from perfiles where menu_nuevo=".$m["menu"]);
   while($rl=mysqli_fetch_assoc($rols)){
    if(!strpos($roles,$rl["denominacion"])){$roles=$roles.$rl["denominacion"]." / ";};
   };

  };
  

  $sheet->setCellValue('A'.ltrim((string)$fl), $r["id"])
        ->setCellValue('B'.ltrim((string)$fl), $r["nombre_reporte"])
        ->setCellValue('C'.ltrim((string)$fl), $r["nombre_menu"])
        ->setCellValue('D'.ltrim((string)$fl), $r["url_principal"])
        ->setCellValue('E'.ltrim((string)$fl), $r["excel"])
        ->setCellValue('F'.ltrim((string)$fl), $menues)
        ->setCellValue('G'.ltrim((string)$fl), $r["definicion_operativa"])
        ->setCellValue('H'.ltrim((string)$fl), $roles)
;
};

$spreadsheet->getActiveSheet()->getStyle('A1:H2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
for($col='A'; $col<= 'H'; $col++){
	ajusta($col);
};

$fl=$fl+2;
 $sheet	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);

$sheet->setTitle('ReportesSURNNYA');
$filename = 'Reportes.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
function ajusta($col){
    global $spreadsheet;
    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);    
}
?>