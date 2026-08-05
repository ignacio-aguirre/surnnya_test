<?php
include("funciones.php");
session_start();
$rubro=nget("rubro");
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$oE = new Spreadsheet();
e_put($oE,'A1', 'Rubro');
e_put($oE,'B1', utf8_encode('Artículo'));
e_put($oE,'C1', utf8_encode('Tipo de Bien'));


$reg=registros("select articulos.descripcion,articulos_rubros.descripcion as rub, idarticulos 
 from articulos left join articulos_rubros on rubro=idarticulos_rubros where articulos.baja is null ".si($rubro==0,""," and rubro=".$rubro).
 " order by articulos_rubros.descripcion, articulos.descripcion");
 $f=2;
  while($r=mysqli_fetch_assoc($reg)){
    e_put($oE,'A'.ltrim((string)$f), $r["rub"]);
    e_put($oE,'B'.ltrim((string)$f), $r["descripcion"]);
    e_put($oE,'C'.ltrim((string)$f), si($r["descripcion"]=="1","Bien de consumo","Bien de uso"));

    $f=$f+1;
  };
  ajusta("A");
  ajusta("B");
  ajusta("C");

$oE->getActiveSheet()->setTitle('Articulos');
$oE->setActiveSheetIndex(0);
$filename = 'Articulos.xlsx';

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

