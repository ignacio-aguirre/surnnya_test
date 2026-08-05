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
            ->setCellValue('B1', 'Solicitudes al Gabinete de Salud en estado Abiertas')
            ->setCellValue('A2', 'Fecha Ingreso')
            ->setCellValue('B2', 'Dispositivo Solicitante')
            ->setCellValue('C2', 'Tipo de Accion Requerida')
            ->setCellValue('D2', 'Apellido y Nombre')
	       ->setCellValue('E2', 'Edad')
	       ->setCellValue('F2', 'Profesion Requerida')
	       ->setCellValue('G2', 'Profesional Asignado')
            ->setCellValue('H2', 'Fecha Primera Accion')
            ->setCellValue('I2', 'Fecha Ultima Accion')
            ->setCellValue('J2', 'Cantidad Acciones');
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:J2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

          
  $sql="select es_participaciones.*, dispositivos.nombre as nombredispo, espe.deno as prof, apellidos, nombres, apellido,es_profesionales.nombre, 
edadcalc(f_nacimiento,sujetosedad,sujetosmeses,null,null) as edc from es_participaciones left join dispositivos on solicitante=dispositivos.id
 left join tablas espe on espe.tipo='ESESP' and espe.valo=es_participaciones.especialidad 
 left join sujetos on es_participaciones.legajo=sujetos.legajo 
 left join es_profesionales on profesional=es_profesionales.id  
where fecha_rechazo is null and fecha_fin is null and fecha_inicio is not null order by apellidos, nombres, fecha_ingreso";

   $reg=registros($sql);
   $soli=0;
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
       $fl=$fl+1;
       $fult=un_campo("select max(fecha) from es_acciones where solicitud=".$r["id"]);
       $cant=un_campo("select count(*) from es_acciones where solicitud=".$r["id"]);
 
       $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["fecha_ingreso"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["nombredispo"])
            ->setCellValue('C'.ltrim((string)$fl), si($r["alcance"]=="1","Intervencion","Institucional"))
            ->setCellValue('D'.ltrim((string)$fl), si($r["legajo"]>0,$r["apellidos"].", ".$r["nombres"],""))
            ->setCellValue('E'.ltrim((string)$fl), si($r["legajo"]>0,$r["edc"],""))
            ->setCellValue('F'.ltrim((string)$fl), $r["prof"])
            ->setCellValue('G'.ltrim((string)$fl), si($r["profesional"]>0,$r["apellido"].", ".$r["nombre"],""))
            ->setCellValue('H'.ltrim((string)$fl), ffec($r["fecha_inicio"]))
            ->setCellValue('I'.ltrim((string)$fl), ffec($fult))
	    ->setCellValue('J'.ltrim((string)$fl), $cant)
 	    ;
       $soli=$soli+1;
     };
     $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $soli." Solicitudes")
 	    ;	
          
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 



for($col='A'; $col<= 'Z'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Solicitudes');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'GS-sol_abiertas.xlsx';

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
           