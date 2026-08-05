<?php
include("funciones.php");
session_start();
$rubro=nget("rubro");
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$oE = new Spreadsheet();

e_put($oE,'A1', utf8_encode('Descripción'));
e_put($oE,'B1', 'Domicilio');
e_put($oE,'C1', 'Localidad');
e_put($oE,'D1', 'Barrio');
e_put($oE,'E1', 'Comuna');
e_put($oE,'F1', utf8_encode('Teléfonos'));


$reg=registros("select * from efectores where baja is null order by descripcion");
$f=2;
while($r=mysqli_fetch_assoc($reg)){
    e_put($oE,'A'.ltrim((string)$f), $r["descripcion"]);
    e_put($oE,'B'.ltrim((string)$f), $r["domicilio"]);
    e_put($oE,'C'.ltrim((string)$f), $r["localidad"]);
    e_put($oE,'D'.ltrim((string)$f), $r["barrio"]);
    e_put($oE,'E'.ltrim((string)$f), $r["comuna"]);
    e_put($oE,'F'.ltrim((string)$f), $r["telefonos"]);

    $f=$f+1;
};
  ajusta("A");
  ajusta("B");
  ajusta("C");
  ajusta("D");
  ajusta("E");
  ajusta("F");

$oE->getActiveSheet()->setTitle('Efectores');
$oE->setActiveSheetIndex(0);
$filename = 'Efectores.xlsx';

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

