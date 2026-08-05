<?php
error_reporting(E_STRICT);
require_once "PHPExcel.php";
session_start();
include("funciones.php");

$fini=fsql($_SESSION["temp_fini"]);
$ffin=fsql($_SESSION["temp_ffin"]);
$bandejas="(1,3,6,7)";
if($_SESSION["bandeja"]=="5"){
  $bandejas="(2,4,5)";
}

$empresa=nget("empresa");
$n_empresa=un_campo("select deno from tablas where tipo='ETRA' and valo=".$empresa);
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
        ->setCreator("SURNNYA");

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Empresa')
            ->setCellValue('B1', 'Especificación renglón')
            ->setCellValue('C1', 'Dispositivo/Sector')
            ->setCellValue('D1', 'Fecha solicitud')
            ->setCellValue('E1', 'Fecha viaje')
            ->setCellValue('F1', 'Hora')
            ->setCellValue('G1', 'Pasajeros NNYA')
            ->setCellValue('H1', 'Pasajeros Adultos')
            ->setCellValue('I1', 'Punto de partida')
            ->setCellValue('J1', 'Destino')
            ->setCellValue('K1', 'Motivo del viaje')
            ->setCellValue('L1', 'Código de viaje')
            ->setCellValue('M1', 'Valor del viaje')
            ->setCellValue('N1', 'Hora adicional')
            ->setCellValue('O1', 'Fracción 10 Minutos')
            ->setCellValue('P1', 'Cantidad 10 KM (solo renglón 7)')
            ->setCellValue('Q1', 'Valor total')
            ->setCellValue('R1', 'Observaciones')
            ->setCellValue('S1', 'Contacto')
;

$reg=registros("select movil_viajes.*, case when dispositivo=0 then sectores.denominacion else dispositivos.nombre end as solicitante, mvmt.deno as motivo, mvtt.deno as renglon from movil_viajes 
    left join dispositivos on dispositivo= dispositivos.id  
    left join sectores on sector= sectores.id  
    left join tablas mvmt on mvmt.tipo='MVMT' and mvmt.valo=motivo_recurso 
    left join tablas mvtt on mvtt.tipo='MVTT' and mvtt.valo=tipo_movil 
    where estado='APR' and movil_viajes.empresa =".$empresa." and movil_viajes.bandeja in ".$bandejas." and movil_viajes.fecha between ".$fini." and ".$ffin. " order by fecha, hora,solicitante");

$fl=1;

while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $destinos=si($r["destino_2"]!="","1.","").$r["destino_1"];
 if($r["destino_2"]!=""){$destinos=$destinos." 2.".$r["destino_2"];};
 if($r["destino_3"]!=""){$destinos=$destinos." 3.".$r["destino_3"];};
 if($r["destino_4"]!=""){$destinos=$destinos." 4.".$r["destino_4"];};
 $pax=registros("select * from movil_pasajeros where viaje=".$r["id"]." and tipo_pasajero=2");
 $cels="";
 while($p=mysqli_fetch_assoc($pax)){
    
    if($p["celular"]!=""){
        $cels=$cels.$p["pas_nombre"]." cel:".$p["celular"]."/";
    };
    
 };
 
 $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.ltrim((string)$fl),$n_empresa)
    ->setCellValue('B'.ltrim((string)$fl), $r["renglon"]) 
    ->setCellValue('C'.ltrim((string)$fl), $r["solicitante"])
    ->setCellValue('D'.ltrim((string)$fl), ffec($r["f_solicitud"]))
    ->setCellValue('E'.ltrim((string)$fl), ffec($r["fecha"]))
    ->setCellValue('F'.ltrim((string)$fl), substr($r["hora"],0,5))
    ->setCellValue('G'.ltrim((string)$fl), $r["pasajeros_alojados"])
    ->setCellValue('H'.ltrim((string)$fl), $r["pasajeros_acompaniantes"])
    ->setCellValue('I'.ltrim((string)$fl), $r["partida"])
    ->setCellValue('J'.ltrim((string)$fl), $destinos)
    ->setCellValue('K'.ltrim((string)$fl),$r["motivo"])
    ->setCellValue('R'.ltrim((string)$fl), $r["comentarios"])
    ->setCellValue('S'.ltrim((string)$fl), $cels)    
;
 
 
};
$fl++;


$fl++;

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Emitido ")
            ->setCellValue('B'.ltrim((string)$fl), $_SESSION["hoy_v"]);
$fl++;    
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Usuario ")
            ->setCellValue('B'.ltrim((string)$fl), $_SESSION["nusuario"]);



for ($col = 'A'; $col <= 'T'; $col++) { 
        cellcolor($col."1","65C8E5");
};          


 
for($col='A'; $col<= 'S'; $col++){
	ajusta($col);
};

ftexto("D1:A1000");
ftexto("E1:P1000");
$objPHPExcel->getActiveSheet()->setTitle('Viajes');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="viajes.xls"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');


exit;

function ajusta($r){
global $objPHPExcel;
$objPHPExcel->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
}
function ftexto($r){
global $objPHPExcel;
$objPHPExcel->getActiveSheet()->getStyle($r)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
}



function cellColor($cells,$color){
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}


?>
           