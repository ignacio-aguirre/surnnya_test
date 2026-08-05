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
            ->setCellValue('B1', utf8_encode('Dir.Operativa'))
            ->setCellValue('C1', 'Dispositivo')
            ->setCellValue('D1', 'Alojados')
            ->setCellValue('E1', 'Plazas')
            ->setCellValue('F1', 'N/D')
   ;
$fech=fget("fecha");
$circ=nget("circuito");
$diop=nget("direccion_operativa");
$fl=1;

$sql="select ong, diop.deno as diope, agub.deno as area, nombre,plazas,count(*) as cantidad,
    (select count(*) from hogares_admision ha2 where ha2.admi_hogar=hogares_admision.admi_hogar and ha2.admi_alta is null and ha2.admi_susp is null)  as ndisp
    from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo
    left join dispositivos on admi_hogar=dispositivos.id
    left join tablas diop on diop.tipo='DIOP' and diop.valo=direccion_operativa
    left join tablas agub on agub.tipo='AGUB' and agub.valo=area_gubernamental
    where admi_alta <=".$fech." and (admi_baja is null or admi_baja>".$fech.") ";
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and direccion_operativa=".$diop;

$sql=$sql." group by area,diope, nombre, ong,plazas,ndisp order by area,diope, nombre, ong,plazas,ndisp";

$reg=registros($sql);
$tot=0;
$pla=0;
$ndi=0;
$propios=0;
$conveniados=0;
$saft=0;
$fl=1;
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
 $pert=si($r["ong"]>0,"CONVENIADOS","PROPIOS");
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $pert)
            ->setCellValue('B'.ltrim((string)$fl), si($r["diope"]=="","N/A - ".$r["area"],$r["diope"]))
            ->setCellValue('C'.ltrim((string)$fl), $r["nombre"])
 	    ->setCellValue('D'.ltrim((string)$fl), $r["cantidad"])
 	    ->setCellValue('E'.ltrim((string)$fl), $r["plazas"])
      ->setCellValue('F'.ltrim((string)$fl), $r["ndisp"])
    ;	
 
 if(substr($pert,0,7)=="PROPIOS"){$propios=$propios+$r["cantidad"];};
 if(substr($pert,0,11)=="CONVENIADOS"){$conveniados=$conveniados+$r["cantidad"];};
 $tot=$tot+$r["cantidad"];
 $pla=$pla+$r["plazas"];
 $ndi=$ndi+$r["ndisp"];
};



 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B'.ltrim((string)$fl), "TOTAL")
            ->setCellValue('D'.ltrim((string)$fl), $tot)
            ->setCellValue('E'.ltrim((string)$fl), $pla)
            ->setCellValue('F'.ltrim((string)$fl), $ndi)
	    ;
$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B'.ltrim((string)$fl), "Pertenencia")
            ->setCellValue('D'.ltrim((string)$fl), "Alojados");
$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B'.ltrim((string)$fl), "PROPIOS")
            ->setCellValue('D'.ltrim((string)$fl), $propios);
$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B'.ltrim((string)$fl), "CONVENIADOS")
            ->setCellValue('D'.ltrim((string)$fl), $conveniados);
	
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Fecha Referencia ".$_GET["fecha"]);
	
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),utf8_encode("Usuario ".$_SESSION["glusua"]));
$f=$fl+3;
	 $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('A'.ltrim((string)$f),"Direccion Operativa ".si($diop=="0","Todas",un_campo("select deno from tablas where tipo='DIOP' and valo=".$diop)));
$f=$f+1;
         $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('A'.ltrim((string)$f),"Circuito ".si($circ=="0","Red de Hogares",si($circ=="1","Preingreso","Residenciales DGSAP")));
 

	

for($col='A'; $col<= 'F'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:F1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$spreadsheet->getActiveSheet()->setTitle('Alojados');
$spreadsheet->setActiveSheetIndex(0);
$filename="Alojados-cantidades.xlsx";
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

function pertenencia($do,$ong){
  if($ong>"0") {return "CONVENIADOS ".$do;} else {return "PROPIOS ".$do;};
}


?>
           