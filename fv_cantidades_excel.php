<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$fl=1;
$spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.ltrim((string)$fl), utf8_encode("Programa Fortalecimiento de Vínculos Familiares y Comunitarios"))
       ->setCellValue('B'.ltrim((string)$fl),"Desde ".$_GET["desde"]."  Hasta ".$_GET["hasta"]);

  $fl=2; 
  $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.ltrim((string)$fl), utf8_encode("Solicitudes activas en el período, por estado"))
	->setCellValue('B'.ltrim((string)$fl), "Cantidad")
	->setCellValue('C'.ltrim((string)$fl), "NNYA")
	->setCellValue('D'.ltrim((string)$fl), "Adultos Conv.")
	->setCellValue('E'.ltrim((string)$fl), "Adultos No Conv.")
	->setCellValue('F'.ltrim((string)$fl), "Grupos Familiares")
;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:F2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion) as estado, count(*) as cantidad,
  sum((select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo where fv_familias_miembros.familia=fv_participaciones.familia and 
  fv_familias_miembros.fecha_alta<=".fget("hasta")." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>".fget("desde").") and edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,".fget("hasta").")<=17)) as nnya,
  sum(adultos_convivientes) as adultos_conv, sum(adultos_noconvivientes) as adultos_nconv, count(distinct familia) as familias  
  from fv_participaciones where estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion)<>'NUL'
  group by estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion) order by
  estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion)"; 
  $reg=registros($sql);
  $activas=0;
  $nnya=0;
  $aduc=0;
  $adnc=0;
  $gru=0;
  while($r=mysqli_fetch_assoc($reg)){
    $activas=$activas+intval($r["cantidad"]);
    $nnya=$nnya+intval($r["nnya"]);
    $aduc=$aduc+intval($r["adultos_conv"]);
    $adnc=$adnc+intval($r["adultos_nconv"]);
    $gru=$gru+intval($r["familias"]);

    $fl=$fl+1;
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.ltrim((string)$fl), $r["estado"])
            ->setCellValue('B'.ltrim((string)$fl), $r["cantidad"])
	    ->setCellValue('C'.ltrim((string)$fl), $r["nnya"])
	    ->setCellValue('D'.ltrim((string)$fl), intval($r["adultos_conv"]))
	    ->setCellValue('E'.ltrim((string)$fl), intval($r["adultos_nconv"]))
	    ->setCellValue('F'.ltrim((string)$fl), intval($r["familias"]))
;
 }; 
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Total")
            ->setCellValue('B'.ltrim((string)$fl), $activas)
	    ->setCellValue('C'.ltrim((string)$fl), $nnya)
	    ->setCellValue('D'.ltrim((string)$fl), $aduc)
	    ->setCellValue('E'.ltrim((string)$fl), $adnc)
	    ->setCellValue('F'.ltrim((string)$fl), $gru);

$ingresadas=un_campo("select count(*) from fv_participaciones where fecha_ingreso between ".fget("desde")." and ".fget("hasta"));
$fl=$fl+2;
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.ltrim((string)$fl), utf8_encode("Solicitudes Ingresadas en el período"))
            ->setCellValue('B'.ltrim((string)$fl), $ingresadas);

$fl=$fl+2;

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), 'Intervenciones Trabajadas, Asignaciones Nuevas y Ceses');
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), 'Centro Zonal')
            ->setCellValue('B'.ltrim((string)$fl), 'Intervenciones Trabajadas')
            ->setCellValue('C'.ltrim((string)$fl), utf8_encode('Asignaciones del Período'))
            ->setCellValue('D'.ltrim((string)$fl), utf8_encode('Ceses del Período'))
	    ->setCellValue('E'.ltrim((string)$fl), 'NNYA')
	    ->setCellValue('F'.ltrim((string)$fl), 'Adultos Conv.')
	    ->setCellValue('G'.ltrim((string)$fl), 'Adultos No Conv.')
	    ->setCellValue('H'.ltrim((string)$fl), 'Grupos Familiares')

   ;
   $sql="select sectores.denominacion,count(*) as activas,
   sum(case when fecha_asignacion between ".fget("desde")." and ".fget("hasta")." then 1 else 0 end) as ingresos,
   sum(case when fecha_baja between ".fget("desde")." and ".fget("hasta")." then 1 else 0 end) as egresos,
   sum((select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo where fv_familias_miembros.familia=fv_participaciones.familia and 
 fv_familias_miembros.fecha_alta<=".fget("hasta")." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>".fget("desde").") and edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,".fget("hasta").")<=17)) as nnya,
   sum(adultos_convivientes) as adultos, sum(adultos_noconvivientes) as adultos_noconv,
   count(distinct familia) as familias   
   from fv_participaciones left join fv_familias on idfv_familias=fv_participaciones.familia 
   left join sectores on efector=sectores.id  
   where estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion) in ('CESE','INTERVENCION') group by denominacion order by denominacion";
   $reg=registros($sql);
   $tac=0;
   $tin=0;
   $teg=0;
   $tna=0;
   $tad=0;
   $tan=0;
   $gru=0;
   while($r=mysqli_fetch_assoc($reg)){
	 $fl=$fl+1;
	 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), utf8_encode(utf8_decode($r["denominacion"])))
            ->setCellValue('B'.ltrim((string)$fl), $r["activas"])
 	    ->setCellValue('C'.ltrim((string)$fl), $r["ingresos"])
 	    ->setCellValue('D'.ltrim((string)$fl), $r["egresos"])
 	    ->setCellValue('E'.ltrim((string)$fl), $r["nnya"])
 	    ->setCellValue('F'.ltrim((string)$fl), $r["adultos"])
 	    ->setCellValue('G'.ltrim((string)$fl), $r["adultos_noconv"])
 	    ->setCellValue('H'.ltrim((string)$fl), $r["familias"])
	    ;
        $tac=$tac+$r["activas"];
   	$tin=$tin+$r["ingresos"];
        $teg=$teg+$r["egresos"];
        $tna=$tna+intval($r["nnya"]);
        $tad=$tad+intval($r["adultos"]);
        $tan=$tan+intval($r["adultos_noconv"]);
	$gru=$gru+intval($r["familias"]);


  };
 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "TOTALES")
            ->setCellValue('B'.ltrim((string)$fl), $tac)
 	    ->setCellValue('C'.ltrim((string)$fl), $tin)
 	    ->setCellValue('D'.ltrim((string)$fl), $teg)
 	    ->setCellValue('E'.ltrim((string)$fl), $tna)
 	    ->setCellValue('F'.ltrim((string)$fl), $tad)
 	    ->setCellValue('G'.ltrim((string)$fl), $tan)
 	    ->setCellValue('H'.ltrim((string)$fl), $gru)
	    ;	

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), utf8_encode("Ceses de Intervención del Período"));
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Motivo")
            ->setCellValue('B'.ltrim((string)$fl), "Cantidad");
$sql="select deno, count(*) as cantidad from fv_participaciones left join tablas on tipo='FVMB' and valo=motivo_baja
 where estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion)='CESE' group by deno order by deno";
 $reg=registros($sql);
 $tb=0;
 while($r=mysqli_fetch_assoc($reg)){
  $fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), utf8_encode($r["deno"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["cantidad"]);
         $tb=$tb+$r["cantidad"];
   };
  $fl=$fl+1;
	 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Total Ceses")
            ->setCellValue('B'.ltrim((string)$fl), $tb);


$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), utf8_encode("Intervenciones según Motivo Intervención"));
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), utf8_encode("Motivo Intervención"))
            ->setCellValue('B'.ltrim((string)$fl), "Cantidad");
  $tab=registros("select valo, deno from tablas where tipo='FVMA' and baja is null order by valo");
  while($t=mysqli_fetch_assoc($tab)){
	$fl=$fl+1;
        $cantidad=un_campo("select count(*) from fv_participaciones 
        where estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion) in ('CESE','INTERVENCION') 
        and (m_asig1=".$t["valo"]." or m_asig2=".$t["valo"]." or m_asig3=".$t["valo"]." or m_asig4=".$t["valo"].")");
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $t["deno"])
            ->setCellValue('B'.ltrim((string)$fl), $cantidad);
  };
$fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), utf8_encode("No se totaliza porque una intervención puede tener de 1 a 4 motivos"));
 
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),utf8_encode("Usuario ".$_SESSION["glusua"]));
	

for($col='A'; $col<= 'H'; $col++){
	ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('FV-cantidades');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'FV-cantidades.xlsx';

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
           