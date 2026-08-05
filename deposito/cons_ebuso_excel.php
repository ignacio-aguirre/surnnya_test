<?php
session_start();
include("funciones.php");
$desde=fget("desde");
$hasta=fget("hasta");
error_reporting(E_STRICT);
require_once "PHPExcel.php";
$objPHPExcel = new PHPExcel();
$objPHPExcel->
    getProperties()
        ->setCategory("reportes");
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E2')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'DDFFF9'),
	    
        )
    )
);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E2')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Desde:'.$_GET["desde"])
->setCellValue('B1', 'Hasta:'.$_GET["hasta"])
->setCellValue('A2', utf8_encode('Fecha'))
->setCellValue('B2', utf8_encode('Remito'))
->setCellValue('C2', utf8_encode('Efector'))
->setCellValue('D2', utf8_encode('Artículo'))
->setCellValue('E2', utf8_encode('F-Estante'))
;

$reg=registros("select fecha,numero,idremitos, nombre,articulos.descripcion as arti,ficha_estante  from remitos_articulos 
  left join remitos on remito=idremitos
  left join articulos on articulo=idarticulos
  where articulos.tipo_bien=2 and fecha between ".$desde." and ".$hasta." order by fecha desc, numero desc");
  $fl=2;
 while($r=mysqli_fetch_assoc($reg)){
 	$fl=$fl+1;
	 $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$fl, ffec($r["fecha"]))
           ->setCellValue('B'.$fl, $r["numero"])
           ->setCellValue('C'.$fl, utf8_encode($r["nombre"]))
           ->setCellValue('D'.$fl, utf8_encode($r["arti"]))
           ->setCellValue('E'.$fl, $r["ficha_estante"])

;
 };

for($col='A'; $col<= 'E'; $col++){
 ajusta($objPHPExcel,$col);
};
 
$objPHPExcel->getActiveSheet()->setTitle('EntregasBU');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
$head='Content-Disposition: attachment;filename="entregasbu.xls"';
header($head);
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

function ajusta($obj,$columnID){
    $obj->getActiveSheet()->getColumnDimension($columnID) 
     ->setAutoSize(true); 
};

?>

