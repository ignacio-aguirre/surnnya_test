<?php
include("funciones.php");
session_start();
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$oE = new Spreadsheet();

e_put($oE,'A1', 'Rubro');
e_put($oE,'B1', 'Cant.Art.');


$reg=registros("select descripcion,(select count(*) from articulos where articulos.baja is null and articulos.rubro=idarticulos_rubros) as cant 
 from articulos_rubros order by articulos_rubros.descripcion");
$f=2;
while($r=mysqli_fetch_assoc($reg)){
    e_put($oE,'A'.ltrim((string)$f), $r["descripcion"]);
    e_put($oE,'B'.ltrim((string)$f), $r["cant"]);
    $f=$f+1;
};
ajusta("A");
ajusta("B");
$oE->getActiveSheet()->setTitle('Rubros');
$oE->setActiveSheetIndex(0);
$filename = 'Rubros.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($oE);
$writer->save('php://output');
exit;

  
function ajusta($r){
global $oE;
$oE->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
};

?>

