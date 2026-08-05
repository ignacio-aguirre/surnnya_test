<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$desde=fget("desde");
$hasta=fget("hasta");
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', 'Acciones del Gabinete de Salud Desde el '.$_GET["desde"]." al ".$_GET["hasta"])
            ->setCellValue('A2', 'Fecha Accion')
            ->setCellValue('B2', 'Dispositivo')
	    ->setCellValue('C2', 'Profesion')
            ->setCellValue('D2', 'Tipo de Accion Realizada')
            ->setCellValue('E2', 'Modalidad')
            ->setCellValue('F2', 'Apellido y Nombre')
	    ->setCellValue('G2', 'Edad')
            ->setCellValue('H2', 'Fecha Solicitud')
            ->setCellValue('I2', 'Observaciones')
	    ->setCellValue('J2', 'Estado');
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:J2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
  
  $sql="select es_acciones.*, nombre, espe.deno as prof, tias.deno as tipa, apellidos, nombres, es_participaciones.fecha_ingreso, 
edadcalc(f_nacimiento,sujetosedad,sujetosmeses,null,null) as edc, tiea.deno as estado from es_acciones 
 left join dispositivos on dispositivo=dispositivos.id
 left join tablas espe on espe.tipo='ESESP' and espe.valo=es_acciones.especialidad 
 left join tablas tias on tias.tipo='ESTIA' and tias.valo=es_acciones.tipo
 left join tablas tiea on tiea.tipo='ESEA' and tiea.valo=es_acciones.estado
 left join sujetos on es_acciones.legajo=sujetos.legajo 
 left join es_participaciones on solicitud=es_participaciones.id 
where estado!=7 and fecha between ".$desde." and ".$hasta." order by fecha";

   $reg=registros($sql);
   $cant=0;
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
 
       $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["fecha"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"].$r["dispositivo_especificar"])
            ->setCellValue('C'.ltrim((string)$fl), $r["prof"])
            ->setCellValue('D'.ltrim((string)$fl), $r["tipa"].si($r["accion_especificar"]=="","",": ".$r["accion_especificar"]))
            ->setCellValue('E'.ltrim((string)$fl), si($r["modalidad"]=="P","Presencial","Virtual"))
            ->setCellValue('F'.ltrim((string)$fl), si($r["legajo"]>0,$r["apellidos"].", ".$r["nombres"],"N/A"))
            ->setCellValue('G'.ltrim((string)$fl), si($r["legajo"]>0,$r["edc"],""))
            ->setCellValue('H'.ltrim((string)$fl), ffec($r["fecha_ingreso"]))
            ->setCellValue('I'.ltrim((string)$fl), $r["observaciones"])
            ->setCellValue('J'.ltrim((string)$fl), $r["estado"])

 	    ;
        $fl_ant=$fl;
        $cant=$cant+1;
  };
     $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $cant." Acciones")
 	    ;	
          
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 



for($col='A'; $col<= 'J'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Acciones');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'GS-acciones.xlsx';

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
};
function estado($r){
if($r["fecha_rechazo"]!=""){return "NO PERTINENTE";};
if($r["fecha_fin"]!=""){return "RESPONDIDA";};
if($r["fecha_inicio"]!=""){return "EN CURSO";};
return "PENDIENTE";
}
?>
           