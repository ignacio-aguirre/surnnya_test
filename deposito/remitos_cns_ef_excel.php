<?php
session_start();
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("funciones.php");
$desde=fget("desde");
$hasta=fget("hasta");
ejecute("delete from temporal_reporte");
ejecute("insert into `temporal_reporte` (articulo,efector,cantidad) SELECT articulos.descripcion,remitos.nombre, 
sum(cantidad) as mes FROM remitos_articulos left join remitos on remito=idremitos
left join articulos on remitos_articulos.articulo=idarticulos
 where fecha between ".$desde." and ".$hasta." group by articulos.descripcion, nombre");
error_reporting(E_STRICT);

$oE = new Spreadsheet();

$oE->getActiveSheet()->getStyle('A1:CZ2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
$oE->setActiveSheetIndex(0)->getStyle('A1:AZ2')->getFont()->setBold(true);
$oE->setActiveSheetIndex(0)->setCellValue('A1', 'Desde:'.$_GET["desde"]);
$oE->setActiveSheetIndex(0)->setCellValue('B1', 'Hasta:'.$_GET["hasta"]);
$oE->setActiveSheetIndex(0)->setCellValue('A2', utf8_encode('ARTÍCULO'));

$cl=0;
$reg=registros("select distinct efector from temporal_reporte order by efector");

while($r=mysqli_fetch_assoc($reg)){
 $cl=$cl+1;          

 $oE->setActiveSheetIndex(0)
           ->setCellValue([$cl,2], $r["efector"]);
 
};
// hasta aca ok

$reg=registros("select * from temporal_reporte order by articulo");
$fl=2;

$ante="@x";
while($r=mysqli_fetch_assoc($reg)){
 if($r["articulo"]!=$ante){
	$fl=$fl+1;
        $ante=$r["articulo"];
	 $oE->setActiveSheetIndex(0)
           ->setCellValue([1,$fl], $r["articulo"]);
 };
 $efector=$r["efector"];
 
 $cl=1;
 while($cl<50 && $efector!=$oE->setActiveSheetIndex(0)->getCell([$cl, 2])->getValue()){
  $cl=$cl+1;

 };
 
 $oE->setActiveSheetIndex(0)
           ->setCellValue([$cl,$fl], $r["cantidad"]);

};

for($col='A'; $col<= 'Z'; $col++){

	ajusta($oE,$col);

};

for($col='A'; $col<= 'Z'; $col++){

	ajusta($oE,'A'.$col);

};

for($col='A'; $col<= 'Z'; $col++){

	ajusta($oE,'B'.$col);

};
for($col='A'; $col<= 'Z'; $col++){

	ajusta($oE,'C'.$col);

};



 
$oE->getActiveSheet()->setTitle('Entregas de Articulos');
$oE->setActiveSheetIndex(0);

$filename = 'Entregas.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($oE);
$writer->save('php://output');
exit;

function ajusta($obj,$columnID){
    $obj->getActiveSheet()->getColumnDimension($columnID) 
     ->setAutoSize(true); 
};

?>

?>