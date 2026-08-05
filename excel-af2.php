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
            ->setCellValue('B1', 'Dispositivo')
            ->setCellValue('C1', 'Familia')
            ->setCellValue('D1', 'Fecha Ingreso')
            ->setCellValue('E1', 'Fecha Baja')
	    ->setCellValue('F1', 'Estado 1 a fecha hasta')
	    ->setCellValue('G1', 'Estado 2 a fecha hasta')
            ->setCellValue('H1', 'C/Acogimiento')
            ->setCellValue('I1', 'Inconsistencias')
            ->setCellValue('J1', 'Id Familia')
            ->setCellValue('K1', 'Estado 1 hoy')
            ->setCellValue('L1', 'Estado 2 hoy')

            ;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:L1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$desd=fget("desde");
$hast=fget("hasta");
$sql="select idaf_familias,case when conveniado=1 then 'CONVENIADO' else 'PAF'  end as pertenencia,nombre,denominacion,fecha_disposicion,fecha_baja,estado1, tipo_prestacion,  
(select count(*) from hogares_admision where admi_hogar=af_familias.hogar and admi_fami=idaf_familias and admi_alta<=".$hast." and (admi_baja is null or admi_baja>".$desd.")) as acogidos from af_familias 
  left join dispositivos on hogar=dispositivos.id ".
   " order by pertenencia,nombre,denominacion"; 
  $tota=0;
  $tota_ca=0;
  $prop=0;
  $prop_ca=0;
  $conv=0;
  $conv_ca=0;	
$fl=1;
$reg = registros($sql);
while ($r = mysqli_fetch_assoc($reg)) {
    $estado1=$r["estado1"];
    $e1_historico=un_campo("select estado1 from af_familias_estados where estado1 is not null and familia=".$r["idaf_familias"]." and fecha<=".$hast." order by fecha desc,fecha_sistema desc limit 1");
    if($e1_historico!=""||true){$estado1=$e1_historico;};  
    $estado2=$r["tipo_prestacion"];
    $e2_historico=un_campo("select estado2 from af_familias_estados where estado2 is not null and familia=".$r["idaf_familias"]." and fecha<=".$hast." order by fecha desc, fecha_sistema desc limit 1");
    if($e2_historico!=""||true){$estado2=$e2_historico;};  
    $inc="";
    if($estado2=="11" && ffec($r["fecha_baja"])==""){
      $inc=$inc . "E2:BajaSinFbaja";
    };
    if($estado2!="11" && ffec($r["fecha_baja"])!=""){
      $inc=$inc . "E2:NoBajaConFbaja";
    };

    if($estado2!="4" && $estado2!="4" && $r["acogidos"]!="0"){
      $inc=$inc . "E2:NoAcogimiento PeroAcoge";
    };
    if(($estado2=="4"||$estado2=="6") && $r["acogidos"]=="0"){
      $inc=$inc . "E2:Acogimiento PeroNoAcoge";
    };
    if($estado1=="1" && ffec($r["fecha_disposicion"])==""){
  	$inc=$inc . "E1:AdmitidaSinFechaAlta";    
    };
    if($estado1!="1" && ffec($r["fecha_disposicion"])!=""){
  	$inc=$inc . "E1:NoAdmitidaConFechaAlta";    
    };
    if($estado2=="" && $estado1=="1") {$inc=$inc. "Advertencia: Sin Estado 2";};
    $fl=$fl+1;
    $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl), $r["pertenencia"])
	->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
	->setCellValue('C'.ltrim((string)$fl), utf8_encode(utf8_decode($r["denominacion"])))
	->setCellValue('D'.ltrim((string)$fl), ffec($r["fecha_disposicion"]))
	->setCellValue('E'.ltrim((string)$fl), ffec($r["fecha_baja"]))
	->setCellValue('F'.ltrim((string)$fl), sacacute(estado1($estado1)))
	->setCellValue('G'.ltrim((string)$fl), sacacute(estado2($estado2)))
        ->setCellValue('H'.ltrim((string)$fl), si($r["acogidos"]>0,1,0))
        ->setCellValue('I'.ltrim((string)$fl), $inc)
        ->setCellValue('J'.ltrim((string)$fl), $r["idaf_familias"])
	->setCellValue('K'.ltrim((string)$fl), sacacute(estado1($r["estado1"])))
	->setCellValue('L'.ltrim((string)$fl), sacacute(estado2($r["tipo_prestacion"])))
;

  /*falta que acumule si se reactiva lo de abajo*/ 			
};
for($col='A'; $col<= 'L'; $col++){
	ajusta($col);
};

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
	->setCellValue('A'.ltrim((string)($fl+2)),"Fechas Desde / Hasta ".$_GET["desde"]." - ".$_GET["hasta"]);

$spreadsheet->getActiveSheet()->setTitle('Familias');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'SAFT-familias.xlsx';

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
function sacacute($t){
$s=str_replace("&oacute;","ó",$t);
return utf8_encode($s);
}
?>
