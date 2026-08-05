<?php
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("funciones.php");
session_start();
$numero=$_GET["numero"];
$pv="1";
$r=un_registro("select * from remitos  where numero=".$numero);
$oE = IOFactory::load('plantillas/RemitosEntrega.xlsx');
$oE->setActiveSheetIndex(0);
e_put($oE,'A2',utf8_encode("Remito de Bienes de Consumo desde Depósito Central"));
e_put($oE,'A8',$r["nombre"]);
e_put($oE,'A12',$r["domicilio"]);
e_put($oE,'A13',$r["localidad"]);
e_put($oE,'E5', ffec($r["fecha"]));
e_put($oE,'E8', "000".$pv."-".$r["numero"]);

$art=registros("select descripcion, cantidad from remitos_articulos left join remitos on remito=idremitos  left join articulos on articulo=idarticulos where numero=".$r["numero"]);
$f=16;
$x=0;
$renglon=0;
while($a=mysqli_fetch_assoc($art)){
 $renglon=$renglon+1;
 $celda='A'.ltrim((string)$f);
 e_put($oE,$celda, $renglon);
 e_put($oE,'B'.ltrim((string)$f), $a["descripcion"]);
 $celda='E'.ltrim((string)$f);
 e_put($oE,$celda, $a["cantidad"]);
 $x=$renglon;
 $f=$f+1;
};

$celdas='A20:D'.ltrim((string)($f-1));
$oE->getActiveSheet()->getStyle($celdas)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$f=$f+1;
e_put($oE,'B'.ltrim((string)$f),utf8_encode("Recibí los artículos detallados en los renglones 1 a ").$x);
$f=$f+3;
e_put($oE,'B'.ltrim((string)$f),"Firma:");
$f=$f+2;
e_put($oE,'B'.ltrim((string)$f),utf8_encode("Aclaración:"));
$f=$f+2;
e_put($oE,'B'.ltrim((string)$f),"DNI:");
ejecute("update remitos set impreso=1 where idremitos=".$r["idremitos"]);
$oE->getActiveSheet()->setTitle('Remito '.$numero);

$filename = 'remito-'.$numero.'.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($oE);
$writer->save('php://output');
exit;
?>







           