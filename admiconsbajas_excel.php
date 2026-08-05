<?php
//error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$desde=fget("desde");
$hasta=fget("hasta");
$diop=nget("direccion_operativa");
$hogar=nget("hogar");
$circ=nget("circuito");
$sheet->setCellValue('A1', 'Apellido y Nombre')
      ->setCellValue('B1', 'RIB')
      ->setCellValue('C1', 'Fecha Nac.')
      ->setCellValue('D1', 'Edad al Egreso')
      ->setCellValue('E1', 'Tipo y Nro. Documento')
      ->setCellValue('F1', 'DZ o Sector Interviniente')
      ->setCellValue('G1', 'Dispositivo')
      ->setCellValue('H1', 'Pertenencia')
      ->setCellValue('I1', 'Fecha de Egreso')
      ->setCellValue('J1', 'Tipo / Motivo de Egreso')
      ->setCellValue('K1', 'Fecha de Ingreso')
      ->setCellValue('L1', utf8_encode('Ds en dispositivo'))
      ->setCellValue('M1', utf8_encode('Ds en disp. previos'))
      ->setCellValue('N1', utf8_encode('Permanencia'));
 $sql="select concat(apellidos,' , ',nombres) as apynomb, concat(tdoc.deno,' ',sujetosdni) as docu, f_nacimiento, nombre, admi_baja, admi_alta, datediff(admi_baja,admi_alta) as dias,rib_anio, rib_numero, rib_reparticion,
 edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) as eda, hogares_motegreso.deno as mote, ong,utec.deno as ut, concat(secto.deno,'-',secto.info) as sector, perm_anterior from hogares_admision  
    left join dispositivos on admi_hogar=dispositivos.id left join sujetos on admi_legajo=sujetos.legajo
    left join sujetos_juridicos on admi_legajo=sujetos_juridicos.legajo 
     left join tablas tdoc on tdoc.tipo='TD' and valo=sujetos.tipodni
     left join tablas secto on secto.tipo='CM' and secto.valo=defensoria_zonal
    left join tablas utec on utec.tipo='SUPUT' and utec.valo=unidad_tecnica
   left join tablas hogares_motegreso on hogares_motegreso.valo=admi_mote and hogares_motegreso.tipo='HOMOE'
  where admi_baja between ".$desde." and ".$hasta;
if($hogar!="null") $sql=$sql." and admi_hogar=".$hogar;
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and area_gubernamental=1 and direccion_operativa=".$diop;

  $sql=$sql." order by apynomb";
 $reg=registros($sql);
 $fl=1;
 $tpro=0;
 $tcon=0;
 $tsaf=0;
 while ($r = mysqli_fetch_assoc($reg)) {
  $fl=$fl+1;
  $apyn=$r["apynomb"];
  $docu=utf8_encode($r["docu"]);
  $fnac=ffec($r["f_nacimiento"]); 
  
  $hoga=$r["nombre"];
  $edad=$r["eda"];
  $mote=$r["mote"];
  $baja=ffec($r["admi_baja"]);
  $alta=ffec($r["admi_alta"]);
  $dias=$r["dias"];
  $pant=$r["perm_anterior"];
  $pert=pertenencia($r["ut"],$r["ong"]);
  $sect=$r["sector"];
  $sheet->setCellValue('A'.ltrim((string)$fl), $apyn)
        ->setCellValue('B'.ltrim((string)$fl), rib2($r))
        ->setCellValue('C'.ltrim((string)$fl), $fnac)
        ->setCellValue('D'.ltrim((string)$fl), $edad)
        ->setCellValue('E'.ltrim((string)$fl), $docu)
        ->setCellValue('F'.ltrim((string)$fl), $sect)
        ->setCellValue('G'.ltrim((string)$fl), $hoga)
        ->setCellValue('H'.ltrim((string)$fl), $pert)
        ->setCellValue('I'.ltrim((string)$fl), $baja)
        ->setCellValue('J'.ltrim((string)$fl), $mote)
        ->setCellValue('K'.ltrim((string)$fl), $alta)
        ->setCellValue('L'.ltrim((string)$fl), $dias)
        ->setCellValue('M'.ltrim((string)$fl), $pant)
        ->setCellValue('N'.ltrim((string)$fl), $dias+$pant);
 if($pert=="PROPIOS"){$tpro=$tpro+1;};
 if($pert=="CONVENIADOS"){$tcon=$tcon+1;};
 if($pert=="SAFT"){$tsaf=$tsaf+1;};


 };
$fl=$fl+1;
$sheet->setCellValue('A'.ltrim((string)$fl), "PROPIOS")
      ->setCellValue('B'.ltrim((string)$fl), $tpro);
$fl=$fl+1;
$sheet->setCellValue('A'.ltrim((string)$fl), "CONVENIADOS")
      ->setCellValue('B'.ltrim((string)$fl), $tcon);
$fl=$fl+1;
$sheet->setCellValue('A'.ltrim((string)$fl), "SAFT")
      ->setCellValue('B'.ltrim((string)$fl), $tsaf);
$fl=$fl+2;
$sheet->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	    ->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
	    ->setCellValue('A'.ltrim((string)($fl+2)),"Fechas Desde / Hasta ".$_GET["desde"]." - ".$_GET["hasta"]);
$f=$fl+3;
$sheet->setCellValue('A'.ltrim((string)$f),"Direccion Operativa ".si($diop=="0","Todas",si($diop=="1","DOAVS","DOIE")));
$f=$f+1;
$sheet->setCellValue('A'.ltrim((string)$f),"Circuito ".si($circ=="0","Red de Hogares",si($circ=="1","Preingreso","Residenciales DGSAP")));
$sheet->getStyle('A1:N1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
for($col='A'; $col<= 'N'; $col++){
	ajusta($col);
};
$spreadsheet->getActiveSheet()->setTitle('Bajas');
$spreadsheet->setActiveSheetIndex(0);

$filename = 'Bajas.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

function ajusta($col){
    global $spreadsheet;
    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);    
} 

function pertenencia($ut,$ong){
  if($ut=="PAF") {return "SAFT";};
  if($ong>"0") {return "CONVENIADOS";} else {return "PROPIOS";};
  return "No Clasificado- Requiere Att";
}


?>
