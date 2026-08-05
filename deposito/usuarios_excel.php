<?php
include("funciones.php");
session_start();
$rubro=nget("rubro");
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$oE = new Spreadsheet;
e_put($oE,'A1', 'Apellido y Nombre');
e_put($oE,'B1', 'CUIL');
e_put($oE,'C1', 'Email');
e_put($oE,'D1', 'Rol');

$reg=registros("select * from usuarios where baja is null order by apellido,nombre");
 $f=2;
  while($r=mysqli_fetch_assoc($reg)){
    e_put($oE,'A'.ltrim((string)$f), $r["apellido"].", ".$r["nombre"]);
    e_put($oE,'B'.ltrim((string)$f), $r["cuil"]);
    e_put($oE,'C'.ltrim((string)$f), $r["email"]);
    e_put($oE,'D'.ltrim((string)$f), si($r["rol"]=="1","Adm.Sistema","Adm.Deposito"));

    $f=$f+1;
  };
  ajusta("A");
  ajusta("B");
  ajusta("C");
  ajusta("D");

  $oE->getActiveSheet()->setTitle('Usuarios');
  $oE->setActiveSheetIndex(0);
  $filename = 'Usuarios.xlsx';
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

