<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Pertenencia')
            ->setCellValue('B1', axel('Unidad Técnica'))
            ->setCellValue('C1', 'Dispositivo')
            ->setCellValue('D1', 'Apellido y Nombre')
            ->setCellValue('E1', 'DNI')
            ->setCellValue('F1', 'RIB')
            ->setCellValue('G1', 'Fecha Nac.')
            ->setCellValue('H1', 'Edad (*)')
            ->setCellValue('I1', 'Sexo')
            ->setCellValue('J1', 'Alta')
            ->setCellValue('K1', 'Baja')
            ->setCellValue('L1', axel('Días'));
   $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:L1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
         
   $desde=fsql($_GET["desde"]);
   $hasta=fsql($_GET["hasta"]);
   $sql="select ong,admi_legajo,deno, nombre, apellidos, nombres, sujetosdni,rib_anio,rib_numero,rib_reparticion, f_nacimiento, edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,".si($r["admi_baja"]=="",fsql($_GET["hasta"]),fsql(ffec($r["admi_baja"]))).") as edad, sexo,h1.admi_alta, admi_baja, perm_anterior+case when permanencia=0 then datediff(".$hasta.",admi_alta)+1 else case when admi_baja>".$hasta." then datediff(".$hasta.",admi_alta)+1 else permanencia end end as total 
  from hogares_admision h1 left join dispositivos on h1.admi_hogar=dispositivos.id 
  left join tablas on tipo='SUPUT' and valo=unidad_tecnica
  left join sujetos on h1.admi_legajo=sujetos.legajo 
  where h1.admi_alta <= ".fsql($_GET["hasta"])." and (h1.admi_baja is null or h1.admi_baja>".fsql($_GET["desde"]).") and tipo_dispositivo in (1,2,11) order by deno, nombre  ";
  $reg=registros($sql);
  $ante="0";
  $nnya=0;
  $tota=0;
  $propios=0;
  $conveniados=0;
  $saft=0;
  $d_propios=0;
  $d_conveniados=0;
  $d_saft=0;

  $fl=1;
  while($r=mysqli_fetch_assoc($reg)){
       if($r["admi_legajo"]!=$ante){
	 $fl=$fl+1;
	$pert=pertenencia($r["deno"],$r["ong"]);
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $pert)
            ->setCellValue('B'.ltrim((string)$fl), $r["deno"])
            ->setCellValue('C'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('D'.ltrim((string)$fl), $r["apellidos"]." , ".$r["nombres"])
 	    ->setCellValue('E'.ltrim((string)$fl), $r["sujetosdni"])	
 	    ->setCellValue('F'.ltrim((string)$fl), rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))	
 	    ->setCellValue('G'.ltrim((string)$fl), ffec($r["f_nacimiento"]))	
 	    ->setCellValue('H'.ltrim((string)$fl), $r["edad"])	
 	    ->setCellValue('I'.ltrim((string)$fl), $r["sexo"])	
 	    ->setCellValue('J'.ltrim((string)$fl), ffec($r["admi_alta"]))	
 	    ->setCellValue('K'.ltrim((string)$fl), ffec($r["admi_baja"]))	
            ->setCellValue('L'.ltrim((string)$fl),$r["total"] );	
         $ante=$r["admi_legajo"];
         $nnya=$nnya+1;
         $tota=$tota+$r["total"];
         if($pert=="PROPIOS"){
         	$propios=$propios+1;
         	$d_propios=$d_propios+$r["total"];
	 };
         if($pert=="CONVENIADOS"){
         	$conveniados=$conveniados+1;
         	$d_conveniados=$d_conveniados+$r["total"];
	 };
         if($pert=="SAFT"){
         	$saft=$saft+1;
         	$d_saft=$d_saft+$r["total"];
	 };


       };
  };
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),axel("Alojados Propios"))
	->setCellValue('A'.ltrim((string)($fl+1)),$propios);
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.ltrim((string)$fl),axel("Permanencia Promedio Propios")) 
        ->setCellValue('A'.ltrim((string)($fl+1)),number_format($d_propios/$propios,2))
        ->setCellValue('B'.ltrim((string)($fl+1)),number_format($d_propios/$propios/31,2)." meses");
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),axel("Alojados Conveniados"))
	->setCellValue('A'.ltrim((string)($fl+1)),$conveniados);
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.ltrim((string)$fl),axel("Permanencia Promedio Conveniados")) 
        ->setCellValue('A'.ltrim((string)($fl+1)),number_format($d_conveniados/$conveniados,2))
        ->setCellValue('B'.ltrim((string)($fl+1)),number_format($d_conveniados/$conveniados/31,2)." meses");
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),axel("Alojados SAFT"))
	->setCellValue('A'.ltrim((string)($fl+1)),$saft);
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.ltrim((string)$fl),axel("Permanencia Promedio SAFT")) 
        ->setCellValue('A'.ltrim((string)($fl+1)),number_format($d_saft/$saft,2))
        ->setCellValue('B'.ltrim((string)($fl+1)),number_format($d_saft/$saft/31,2)." meses");

  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),axel("Total Alojados"))
	->setCellValue('A'.ltrim((string)($fl+1)),$nnya);
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.ltrim((string)$fl),axel("Permanencia Promedio Total")) 
        ->setCellValue('A'.ltrim((string)($fl+1)),number_format($tota/$nnya,2))
        ->setCellValue('B'.ltrim((string)($fl+1)),number_format($tota/$nnya/31,2)." meses");
 
$fl=$fl+3;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
	->setCellValue('A'.ltrim((string)($fl+2)),"Fechas Desde / Hasta ".$_GET["desde"]." - ".$_GET["hasta"]);
 
$fl=$fl+3;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"(*) Las edades incluidas en este reporte se calularon a la menor fecha entre fecha de egreso, y ".$_GET["hasta"]);



for($col='B'; $col<= 'L'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Permanencia');
$filename = 'Permanencia.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

function pertenencia($ut,$ong){
  if($ut=="DIOPE DGPPAU PAF") {return "SAFT";};
  if($ong>"0") {return "CONVENIADOS";}
  else{return "PROPIOS";};
  return "No Clasificado- Requiere Att";
}

function ajusta($r){
global $spreadsheet;
$spreadsheet->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
};
?>
           