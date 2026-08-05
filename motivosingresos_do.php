<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Motivo de Ingreso')
            ->setCellValue('B1', 'Cantidad');
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:B1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$condicion=" area_gubernamental=1";
if(nget("direccion_operativa")!="0"){$condicion=$condicion." and direccion_operativa=".nget(direccion_operativa);};
if(nget("circuito")!="0"){$condicion=$condicion." and tipo_dispositivo=".si(nget("circuito")=="1","11","2");};

$sql="SELECT deno, count(*) as cantidad FROM `sujetos` left join tablas on ming1=valo and tipo='MISUP'
WHERE legajo in (select distinct admi_legajo from hogares_admision 
 left join dispositivos on admi_hogar=dispositivos.id where deno is not null and ".$condicion." and admi_alta<=".fsql($_GET["hasta"])." and (admi_baja is null or admi_baja>=".fsql($_GET["desde"]).")) 
 group by deno	
 union all 
SELECT deno, count(*) as cantidad  FROM `sujetos` left join tablas on ming2=valo and tipo='MISUP'
WHERE legajo in (select distinct admi_legajo from hogares_admision 
 left join dispositivos on admi_hogar=dispositivos.id where deno is not null and ".$condicion." and admi_alta<=".fsql($_GET["hasta"])." and (admi_baja is null or admi_baja>=".fsql($_GET["desde"]).")) 
 group by deno
 union all  
SELECT deno, count(*) as cantidad FROM `sujetos` left join tablas on ming3=valo and tipo='MISUP'
WHERE legajo in (select distinct admi_legajo from hogares_admision 
 left join dispositivos on admi_hogar=dispositivos.id where deno is not null and ".$condicion." and admi_alta<=".fsql($_GET["hasta"])." and (admi_baja is null or admi_baja>=".fsql($_GET["desde"]).")) 
 group by deno
 order by deno"; 
$reg=registros($sql);
$fl=1;
$ante="fake";
while($r=mysqli_fetch_assoc($reg)){
 if($r["deno"]!=$ante){$fl=$fl+1;$ante=$r["deno"];$cant=0;};
    $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), si($r["deno"]=="","Sin datos",$r["deno"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["cantidad"]+$cant);
    $cant=$cant+$r["cantidad"];
};
$nnya=un_campo("select count(distinct admi_legajo) from hogares_admision 
 left join dispositivos on admi_hogar=dispositivos.id 
 where ".$condicion." and admi_alta<=".fsql($_GET["hasta"])." and (admi_baja is null or admi_baja>=".fsql($_GET["desde"]).")");
$sindatos=un_campo("select count(distinct admi_legajo) from hogares_admision 
 left join dispositivos on admi_hogar=dispositivos.id left join sujetos on admi_legajo=sujetos.legajo  
 where (not ming1>0 and not ming2>0 and not ming3>0) and ".$condicion." and admi_alta<=".fsql($_GET["hasta"])." and (admi_baja is null or admi_baja>=".fsql($_GET["desde"]).")");

$fl=$fl+2;
    $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $nnya." NNYA")
            ->setCellValue('A'.ltrim((string)$fl+1), $sindatos." sin datos")
         ;
$fl=$fl+3;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Desde ".$_GET["desde"]." / Hasta ".$_GET["hasta"]);
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),'Direccion Operativa '.si($_GET["direccion_operativa"]==0,"Todas",si($_GET["direccion_operativa"]==1,"DOAVS","DOIE")));
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),'Circuito '.si($_GET["circuito"]==0,"Todos",si($_GET["circuito"]==1,"PREINGRESO","RED DE HOGARES")));

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'B'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('MotivosIngresos');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Motivos-ingreso.xlsx';

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
}
?>