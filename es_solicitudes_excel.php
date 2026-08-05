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
            ->setCellValue('B1', 'Solicitudes al Gabinete de Salud Desde el '.$_GET["desde"]." al ".$_GET["hasta"])
            ->setCellValue('A2', 'Fecha Ingreso')
            ->setCellValue('B2', 'Dispositivo Solicitante')
            ->setCellValue('C2', 'Tipo de Accion Requerida')
            ->setCellValue('D2', 'Apellido y Nombre')
	    ->setCellValue('E2', 'Edad')
	    ->setCellValue('F2', 'Profesion Requerida')
            ->setCellValue('G2', 'Fecha Primera Accion')
            ->setCellValue('H2', 'Fecha Ultima Accion')
            ->setCellValue('I2', 'Cantidad Acciones')
            ->setCellValue('J2', 'Fecha Cierre')
            ->setCellValue('K2', 'Estado')
            ->setCellValue('L2', 'Fecha')
            ->setCellValue('M2', 'Accion')
            ->setCellValue('N2', 'Profesion')
            ->setCellValue('O2', 'Dispositivo')
            ->setCellValue('P2', 'Observaciones')
            ->setCellValue('Q2', '#id Solicitud')
            ->setCellValue('R2', '#id Accion');
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:R2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
          
  $sql="select es_participaciones.*, nombre, espe.deno as prof, apellidos, nombres, 
edadcalc(f_nacimiento,sujetosedad,sujetosmeses,null,null) as edc from es_participaciones left join dispositivos on solicitante=dispositivos.id
 left join tablas espe on espe.tipo='ESESP' and espe.valo=es_participaciones.especialidad 
 left join sujetos on es_participaciones.legajo=sujetos.legajo 
where fecha_ingreso between ".$desde." and ".$hasta." order by fecha_ingreso";

   $reg=registros($sql);
   $soli=0;
   $accio=0;
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
       $fult=un_campo("select max(fecha) from es_acciones where estado=2 and solicitud=".$r["id"]);
       $cant=un_campo("select count(*) from es_acciones where estado=2 and solicitud=".$r["id"]);
 
       $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["fecha_ingreso"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('C'.ltrim((string)$fl), si($r["alcance"]=="1","Intervencion","Institucional"))
            ->setCellValue('D'.ltrim((string)$fl), si($r["legajo"]>0,$r["apellidos"].", ".$r["nombres"],""))
            ->setCellValue('E'.ltrim((string)$fl), si($r["legajo"]>0,$r["edc"],""))
            ->setCellValue('F'.ltrim((string)$fl), $r["prof"])
            ->setCellValue('G'.ltrim((string)$fl), ffec($r["fecha_inicio"]))
            ->setCellValue('H'.ltrim((string)$fl), ffec($fult))
	    ->setCellValue('I'.ltrim((string)$fl), $cant)
            ->setCellValue('J'.ltrim((string)$fl), ffec($r["fecha_fin"]))
	    ->setCellValue('K'.ltrim((string)$fl), estado($r))
	    ->setCellValue('Q'.ltrim((string)$fl), $r["id"])

 	    ;
        $fl_ant=$fl;
        $soli=$soli+1;
        $acc=registros("select es_acciones.*, tias.deno as tipoaccion, espe.deno as prof, nombre 
 from es_acciones left join dispositivos on dispositivo=dispositivos.id left join tablas tias on tias.tipo='ESTIA' and tias.valo=es_acciones.tipo 
 left join tablas espe on espe.tipo='ESESP' and espe.valo=especialidad where estado=2 and solicitud=".$r["id"]." order by fecha");
   while($a=mysqli_fetch_assoc($acc)){
       $accio=$accio+1;
       $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('L'.ltrim((string)$fl), ffec($a["fecha"]))
            ->setCellValue('M'.ltrim((string)$fl), $a["tipoaccion"].si($a["accion_especificar"]=="","",": ".$a["accion_especificar"]))
            ->setCellValue('N'.ltrim((string)$fl), $a["prof"])
            ->setCellValue('O'.ltrim((string)$fl), $a["nombre"])
            ->setCellValue('P'.ltrim((string)$fl), $a["observaciones"])
	    ->setCellValue('R'.ltrim((string)$fl), $a["id"])

 ;
  $fl=$fl+1;
   };      
  if($fl>$fl_ant){$fl=$fl-1;};
  };
     $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('Q'.ltrim((string)$fl), $soli." Solicitudes")
            ->setCellValue('R'.ltrim((string)$fl), $accio." Acciones")

 	    ;	
          
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 



for($col='A'; $col<= 'R'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Solicitudes');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'GS-solicitudes.xlsx';

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
           