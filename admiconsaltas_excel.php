<?php
//error_reporting(E_STRICT);
// error_reporting(E_STRICT);
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
            ->setCellValue('D1', 'Edad al Ingreso')
            ->setCellValue('E1', 'Tipo y Nro. Documento')
            ->setCellValue('F1', 'Organismo Solicitante')
            ->setCellValue('G1', 'Dispositivo')
            ->setCellValue('H1', 'Pertenencia')
            ->setCellValue('I1', 'Fecha de Ingreso')
            ->setCellValue('J1', 'Tipo / Motivo de Ingreso');
 $sql="select concat(apellidos,' , ',nombres) as apynomb, concat(tdoc.deno,' ',sujetosdni) as docu, f_nacimiento, concat(secto.deno,'-',secto.info) as deri,
nombre, admi_alta, rib_anio, rib_numero, rib_reparticion,
 edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta) as eda, ming.deno as moti, ong,utec.deno as ut from hogares_admision  
    left join dispositivos on admi_hogar=dispositivos.id left join sujetos on admi_legajo=sujetos.legajo
     left join tablas tdoc on tdoc.tipo='TD' and valo=sujetos.tipodni
     left join tablas secto on secto.tipo='CM' and secto.valo=admi_deriv_sector
    left join tablas utec on utec.tipo='SUPUT' and utec.valo=unidad_tecnica
   left join tablas ming on ming.tipo='HOMOI' and ming.valo=admi_moti 
  where admi_alta between ".$desde." and ".$hasta;
if($hogar!="null") $sql=$sql." and admi_hogar=".$hogar;
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and direccion_operativa=".$diop;
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
  $deri=utf8_encode($r["deri"]);
  $hoga=$r["nombre"];
  $edad=$r["eda"];
  $moti=$r["moti"];
  $alta=utf8_encode(ffec($r["admi_alta"]));
  $pert=pertenencia($r["ut"],$r["ong"]);
  $sheet->setCellValue('A'.ltrim((string)$fl), $apyn)
            ->setCellValue('B'.ltrim((string)$fl), rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))
            ->setCellValue('C'.ltrim((string)$fl), $fnac)
            ->setCellValue('D'.ltrim((string)$fl), $edad)
            ->setCellValue('E'.ltrim((string)$fl), $docu)
            ->setCellValue('F'.ltrim((string)$fl), $deri)
            ->setCellValue('G'.ltrim((string)$fl), $hoga)
            ->setCellValue('H'.ltrim((string)$fl), $pert)
            ->setCellValue('I'.ltrim((string)$fl), $alta)
            ->setCellValue('J'.ltrim((string)$fl), $moti);
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
$sheet->getStyle('A1:J1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

for($col='A'; $col<= 'J'; $col++){
	ajusta($col);
};
$spreadsheet->getActiveSheet()->setTitle('Altas');
$spreadsheet->setActiveSheetIndex(0);

$filename = 'Altas.xlsx';

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
  if($ong>"0") {return "CONVENIADOS";}else {return "PROPIOS";};
  return "No Clasificado- Requiere Att";
}

?>



           