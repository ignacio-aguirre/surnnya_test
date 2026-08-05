<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$desd=fget("desde");
$hast=fget("hasta");
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', 'Indicadores Gabinete de Salud '.$_GET["desde"]." - ".$_GET["hasta"])
            ->setCellValue('A2', 'Nombre')
            ->setCellValue('B2', utf8_encode('Descripción'))
            ->setCellValue('C2', 'Valor');
$fl=3;

$spreadsheet->setActiveSheetIndex(0)
->setCellValue('B'.ltrim((string)$fl),"a. Acciones");
$apro=un_campo("select count(*) from es_acciones where estado in(2,3,4) and fecha between ".$desd." and ".$hast);
$area=un_campo("select count(*) from es_acciones where estado =2 and fecha between ".$desd." and ".$hast);

$auca=un_campo("select count(*) from es_acciones where estado=3 and fecha between ".$desd." and ".$hast);
$ausa=un_campo("select count(*) from es_acciones where estado=4 and fecha between ".$desd." and ".$hast);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Acciones Programadas")
->setCellValue('B'.ltrim((string)$fl),"Cantidad acciones programadas por el GDS (# Intervenciones + # Acc institucionales)")
->setCellValue('C'.ltrim((string)$fl),$apro);

$fl=$fl+1;

$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Acciones ausentes con aviso")
->setCellValue('B'.ltrim((string)$fl),"Cantidad acciones ausentes con aviso")
->setCellValue('C'.ltrim((string)$fl),$auca);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Acciones ausentes con aviso")
->setCellValue('B'.ltrim((string)$fl),"% Acciones ausentes con aviso")
->setCellValue('C'.ltrim((string)$fl),si($apro>0,number_format(100*$auca/$apro,2),""));

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Acciones ausentes sin aviso")
->setCellValue('B'.ltrim((string)$fl),"Cantidad acciones ausentes sin aviso")
->setCellValue('C'.ltrim((string)$fl),$ausa);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Acciones ausentes sin aviso")
->setCellValue('B'.ltrim((string)$fl),"% Acciones ausentes sin aviso")
->setCellValue('C'.ltrim((string)$fl),si($apro>0,number_format(100*$ausa/$apro,2),""));

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Acciones realizadas")
->setCellValue('B'.ltrim((string)$fl),"Cantidad acciones realizadas por el GDS (# Intervenciones + # Acc institucionales)")
->setCellValue('C'.ltrim((string)$fl),$area);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Acciones realizadas")
->setCellValue('B'.ltrim((string)$fl),"% Acciones realizadas")
->setCellValue('C'.ltrim((string)$fl),si($apro>0,number_format(100*$area/$apro,2),""));

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('B'.ltrim((string)$fl),"En las siguientes # y % de acciones se consideran las efectivamente realizadas");

$fl=$fl+1;
$insti=un_campo("select count(*) from es_acciones where estado=2 and alcance=2 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Acc Institucionales")
->setCellValue('B'.ltrim((string)$fl),"Cantidad acciones institucionales realizadas por el GDS")
->setCellValue('C'.ltrim((string)$fl),$insti);

$fl=$fl+1;
$inte=un_campo("select count(*) from es_acciones where estado=2 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Intervenciones")
->setCellValue('B'.ltrim((string)$fl),"Cantidad intervenciones realizadas por el GDS " . 
"(# Entr.Admision + # Ev.Integrales + # Int.Espontaneas + # Aptos + # Tratamientos + # Seguimientos + # Articulaciones)")
->setCellValue('C'.ltrim((string)$fl),$inte);

$fl=$fl+1;
$segu=un_campo("select count(*) from es_acciones where estado=2 and tipo=8 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Seguimientos")
->setCellValue('B'.ltrim((string)$fl),"Cantidad seguimientos realizados por el GDS")
->setCellValue('C'.ltrim((string)$fl),$segu);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Seguimientos")
->setCellValue('B'.ltrim((string)$fl),"% seguimientos realizados por el GDS sobre total de intervenciones")
->setCellValue('C'.ltrim((string)$fl),si($inte>0,number_format(100*$segul/$inte,2),""));

$fl=$fl+1;
$eval=un_campo("select count(*) from es_acciones where estado=2 and tipo=4 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Entr.Admision")
->setCellValue('B'.ltrim((string)$fl),"Cantidad entrevistas de admision realizadas por el GDS")
->setCellValue('C'.ltrim((string)$fl),$eval);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Entr.Admision")
->setCellValue('B'.ltrim((string)$fl),"% entrevistas de admision realizadas por el GDS sobre total de intervenciones")
->setCellValue('C'.ltrim((string)$fl),si($inte>0,number_format(100*$eval/$inte,2),""));

$fl=$fl+1;
$eint=un_campo("select count(*) from es_acciones where estado=2 and tipo=6 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Ev.Integrales")
->setCellValue('B'.ltrim((string)$fl),"Cantidad evaluaciones integrales realizadas por el GDS")
->setCellValue('C'.ltrim((string)$fl),$eint);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Ev.Integrales")
->setCellValue('B'.ltrim((string)$fl),"% evaluaciones integrales realizadas por el GDS sobre total de intervenciones")
->setCellValue('C'.ltrim((string)$fl),si($inte>0,number_format(100*$eint/$inte,2),""));

$fl=$fl+1;
$cons=un_campo("select count(*) from es_acciones where estado=2 and tipo=1 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Int.Espontaneas")
->setCellValue('B'.ltrim((string)$fl),"Cantidad intervenciones espontaneas realizadas por el GDS")
->setCellValue('C'.ltrim((string)$fl),$cons);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Int.Espontaneas")
->setCellValue('B'.ltrim((string)$fl),"% intervenciones espontaneas realizadas por el GDS sobre total de intervenciones")
->setCellValue('C'.ltrim((string)$fl),si($inte>0,number_format(100*$cons/$inte,2),""));

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Total Evaluaciones")
->setCellValue('B'.ltrim((string)$fl),"Total evaluaciones (# Entr.Admision + # Ev. Integral + # Int. Espontaneas) realizadas por el GDS")
->setCellValue('C'.ltrim((string)$fl),$eval+$eint+$cons);

$fl=$fl+1;
$apto=un_campo("select count(*) from es_acciones where estado=2 and tipo=2 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Aptos")
->setCellValue('B'.ltrim((string)$fl),"Cantidad aptos medicos realizados por el GDS")
->setCellValue('C'.ltrim((string)$fl),$apto);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Aptos")
->setCellValue('B'.ltrim((string)$fl),"% aptos medicos realizados por el GDS sobre total de intervenciones")
->setCellValue('C'.ltrim((string)$fl),si($inte>0,number_format(100*$apto/$inte,2),""));

$fl=$fl+1;
$trat=un_campo("select count(*) from es_acciones where estado=2 and tipo=3 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Tratamientos")
->setCellValue('B'.ltrim((string)$fl),"Cantidad tratamientos realizados por el GDS")
->setCellValue('C'.ltrim((string)$fl),$trat);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Tratamientos")
->setCellValue('B'.ltrim((string)$fl),"% tratamientos realizados por el GDS sobre total de intervenciones")
->setCellValue('C'.ltrim((string)$fl),si($inte>0,number_format(100*$trat/$inte,2),""));

$fl=$fl+1;
$segu=un_campo("select count(*) from es_acciones where estado=2 and tipo=8 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Seguimientos")
->setCellValue('B'.ltrim((string)$fl),"Cantidad seguimientos realizados por el GDS")
->setCellValue('C'.ltrim((string)$fl),$segu);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Seguimientos")
->setCellValue('B'.ltrim((string)$fl),"% seguimientos realizados por el GDS sobre total de intervenciones")
->setCellValue('C'.ltrim((string)$fl),si($inte>0,number_format(100*$segu/$inte,2),""));

$fl=$fl+1;
$arti=un_campo("select count(*) from es_acciones where estado=2 and tipo=7 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Articulaciones")
->setCellValue('B'.ltrim((string)$fl),"Cantidad articulaciones realizadas por el GDS")
->setCellValue('C'.ltrim((string)$fl),$arti);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% Articulaciones")
->setCellValue('B'.ltrim((string)$fl),"% articulaciones realizadas por el GDS sobre total de intervenciones")
->setCellValue('C'.ltrim((string)$fl),si($inte>0,number_format(100*$arti/$inte,2),""));

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('B'.ltrim((string)$fl),"b. NNYA abordados");

$fl=$fl+1;
$nnya=un_campo("select count(distinct legajo) from es_acciones where estado=2 and alcance=1 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# NNyA")
->setCellValue('B'.ltrim((string)$fl),"Cantidad de NNyA abordados por el GDS")
->setCellValue('C'.ltrim((string)$fl),$nnya);

$fl=$fl+1;
$nnyaa=un_campo("select count(distinct legajo) from es_acciones where estado=2 and alcance=1 and dispositivo>0 and fecha between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# NNyA Alojados")
->setCellValue('B'.ltrim((string)$fl),"Cantidad de NNyA abordados por el GDS que se encuentran alojados en hogares convivenciales")
->setCellValue('C'.ltrim((string)$fl),$nnyaa);

$fl=$fl+1;
$nnyap=un_campo("select count(distinct legajo) from es_participaciones where  alcance=1 and fecha_ingreso<=".$hast." and fecha_rechazo is null and ( fecha_inicio is null or fecha_inicio>".$hast.")");
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# NNyA Pendientes Intervencion")
->setCellValue('B'.ltrim((string)$fl),"Cantidad NNyA pendientes de intervenir al cierre del mes")
->setCellValue('C'.ltrim((string)$fl),$nnyap);

$fl=$fl+1;
$nnyapft=un_campo("select count(distinct legajo) from es_participaciones where  alcance=1 and fecha_ingreso<=".$hast." and fecha_rechazo is null and ( fecha_inicio is null or fecha_inicio>".$hast.") and datediff(".$hast.",fecha_ingreso)>10");
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# NNyA Pend Intervencion c/espera superior")
->setCellValue('B'.ltrim((string)$fl),"Cantidad NNyA pendientes de intervenir cuya espera supera tiempo establecido como meta para dar respuesta")
->setCellValue('C'.ltrim((string)$fl),$nnyapft);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('B'.ltrim((string)$fl),"c. Solicitudes");

$fl=$fl+1;
$soli=un_campo("select count(*) from es_participaciones where fecha_ingreso between ".$desd." and ".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Solicitudes Ingresadas")
->setCellValue('B'.ltrim((string)$fl),"Cantidad solicitudes ingresadas en periodo")
->setCellValue('C'.ltrim((string)$fl),$soli);

$fl=$fl+1;
$pend=un_campo("select count(*) from es_participaciones where fecha_ingreso<".$desd." and fecha_rechazo is null and (fecha_inicio is null or fecha_inicio>=".$desd.")");
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Solicitudes Anteriores Pendientes")
->setCellValue('B'.ltrim((string)$fl),"Cantidad solicitudes pendientes meses anteriores")
->setCellValue('C'.ltrim((string)$fl),$pend);

$fl=$fl+1;
$atrab=$pend+$soli;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Total Solicitudes")
->setCellValue('B'.ltrim((string)$fl),"# Solicitudes Ingresadas + # Solicitudes Anteriores Pendientes")
->setCellValue('C'.ltrim((string)$fl),$atrab);


$fl=$fl+1;
$sresp=un_campo("select count(*) from es_participaciones where fecha_inicio between ".$desd." and ". $hast." and fecha_ingreso<=".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Solicitudes Respondidas")
->setCellValue('B'.ltrim((string)$fl),"Cantidad solicitudes respondidas (ingresadas en periodo o anteriormente)")
->setCellValue('C'.ltrim((string)$fl),$sresp);

$fl=$fl+1;
$solrt=un_campo("select count(*) from es_participaciones where datediff(fecha_inicio,fecha_ingreso)<=10 and fecha_inicio between ".$desd." and ".$hast." and fecha_ingreso<=".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Respuestas dentro tiempo")
->setCellValue('B'.ltrim((string)$fl),"Cantidad solicitudes a las que se dio respuesta dentro del tiempo de respuesta establecido como meta (10 dias)")
->setCellValue('C'.ltrim((string)$fl),$solrt);

$fl=$fl+1;
$prom=un_campo("select avg(datediff(fecha_inicio,fecha_ingreso)) from es_participaciones where fecha_inicio between ".$desd." and ".$hast." and fecha_ingreso<=".$hast);
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"Promedio Tiempo Respuesta")
->setCellValue('B'.ltrim((string)$fl),"Promedio de dias para responder ante el pedido de intervenciones")
->setCellValue('C'.ltrim((string)$fl),number_format($prom,2));

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"% SLA de respuesta a solicitudes")
->setCellValue('B'.ltrim((string)$fl),"Cantidad solicitudes a las que se dio respuesta dentro del tiempo establecido como meta sobre el total de evaluaciones realizadas (como primera respuesta)s")
->setCellValue('C'.ltrim((string)$fl),si($atrab>0,number_format(100*$solrt/$sresp,2),""));

$fl=$fl+1;
$pendp=un_campo("select count(*) from es_participaciones where fecha_ingreso<=".$hast." and fecha_rechazo is null and (fecha_inicio is null or fecha_inicio>".$hast.")");
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"# Solicitudes Pendientes")
->setCellValue('B'.ltrim((string)$fl),"Cantidad solicitudes pendientes a fin del periodo")
->setCellValue('C'.ltrim((string)$fl),$pendp);



$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 




ajusta('A');
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth("130");

$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:D3')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$spreadsheet->setActiveSheetIndex(0)->getStyle('A11:D11')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$spreadsheet->setActiveSheetIndex(0)->getStyle('A31:D31')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$spreadsheet->setActiveSheetIndex(0)->getStyle('A36:D36')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$spreadsheet->getActiveSheet()->setTitle('Indicadores');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'GS-indicadores.xlsx';

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
?>
           