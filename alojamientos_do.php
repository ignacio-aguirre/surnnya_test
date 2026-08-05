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
            ->setCellValue('A1', 'Unidad Tecnica')
            ->setCellValue('B1', 'Hogar')
            ->setCellValue('C1', 'Gestion')
            ->setCellValue('D1', 'Circuito')
            ->setCellValue('E1', 'Dir.Operativa')
            ->setCellValue('F1', 'Apellido y Nombre')
            ->setCellValue('G1', 'Sexo')
            ->setCellValue('H1', 'Genero')
            ->setCellValue('I1', 'Edad (*)')
            ->setCellValue('J1', 'Fecha Nac.')
            ->setCellValue('K1', 'Tipo y Nro.Doc.')
            ->setCellValue('L1', 'RIB')
            ->setCellValue('M1', 'Alta')
            ->setCellValue('N1', 'Baja')
            ->setCellValue('O1', 'Mot.Egreso')
            ->setCellValue('P1', 'Defensoria')
            ->setCellValue('Q1', 'TipoMedida')
            ->setCellValue('R1', 'Juzg.Fuero')
            ->setCellValue('S1', 'Juzg.Nro.')
            ->setCellValue('T1', 'Exp.')
            ->setCellValue('U1', 'Caratula')
            ->setCellValue('V1', 'Ult.Res.Familiar')
            ->setCellValue('W1', 'Grupo de Hermanos')
            ->setCellValue('X1','MI1')
            ->setCellValue('Y1','CMI1')
            ->setCellValue('Z1','MI2')
            ->setCellValue('AA1','CMI2')
            ->setCellValue('AB1','MI3')
            ->setCellValue('AC1','CMI3')
            ->setCellValue('AD1','VC1')
            ->setCellValue('AE1','CVC1')
            ->setCellValue('AF1','VC2')
            ->setCellValue('AG1','CVC2')
            ->setCellValue('AH1','VC3')
            ->setCellValue('AI1','CVC3')
            ->setCellValue('AJ1','EE')
            ->setCellValue('AK1','CEE')
            ->setCellValue('AL1','EstadoEE')
            ->setCellValue('AM1','CEEE')
            ->setCellValue('AN1','Dec.5')
;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:AN1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$sql="select tbut.deno as utec, nombre, sujetos.legajo,apellidos, nombres, sexo, genero, genero_cual,edadcalc(f_nacimiento,sujetosedad,sujetosMeses,sujetosActedad,".$hasta.") as edac, f_nacimiento, tbtd.deno as tdoc, sujetosdni, rib_anio, rib_numero, rib_reparticion, decreto_5, 
 vivi.descripcion as vivi, ong, tdes.deno as tdis, agub.deno as area, tipo_dispositivo, tdio.deno as diop, 
 admi_alta, admi_baja,juzgado_modalidad,juzgado_numero,juzgado_expediente,juzgado_caratula,
tbdz.deno as dezo,tbtm.deno as tmed, tbme.deno as mote, ming1, ming2, ming3, ctex1, ctex2, ctex3, es_egreso, es_egreso_estado,tgen.deno as gene     

 from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar 
 left join sujetos on admi_legajo=sujetos.legajo 
 left join localidades vivi on locvivienda=vivi.idlocalidades 
 left join sujetos_juridicos on sujetos_juridicos.legajo=admi_legajo 
 left join tablas as tbtd on tbtd.tipo='TD' and tipoDni=tbtd.valo 
 left join tablas as tbme on tbme.tipo='HOMOE' and admi_mote=tbme.valo
 left join tablas as tbdz on tbdz.tipo='CM' and tbdz.valo=defensoria_zonal 
 left join tablas as tbtm on tbtm.tipo='TM' and tbtm.valo=tipo_medida 
 left join tablas as tbut on tbut.tipo='SUPUT' and tbut.valo=unidad_tecnica
 left join tablas as agub on agub.tipo='AGUB' and agub.valo=area_gubernamental
 left join tablas as tdes on tdes.tipo='DITIP' and tdes.valo=tipo_dispositivo
 left join tablas as tdio on tdio.tipo='DIOP' and tdio.valo=direccion_operativa 
 left join tablas as tgen on tgen.tipo='GENER' and tgen.valo=sujetos.genero  
 where admi_alta<=".$hasta." and (admi_baja is null or admi_baja>=".$desde.") ";
$diop=nget("direccion_operativa");
$circ=nget("circuito");
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and direccion_operativa=".$diop;
$sql=$sql." order by utec, nombre";
$fl=1;


$reg=registros($sql);
$fl=1;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;

 $gest=si($r["ong"]>"0","CONVENIADOS","PROPIOS");
 if($r["area"]=="DGSAP"){
   $circu="DGSAP - ".$r["tdis"];
   $diope=$r["diop"];
  }
 else{
  $circu="RED DE HOGARES - ".$r["tdis"]; 
  $diope="N/A ".$r["area"];
 };
 $gene=$r["gene"];
 $docu=$r["tdoc"]." ".$r["sujetosdni"];  
 $alta=ffec($r["admi_alta"]);                 //alta
 $baja=ffec($r["admi_baja"]);                 //baja
 

 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["utec"])
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('C'.ltrim((string)$fl), $gest)
            ->setCellValue('D'.ltrim((string)$fl), $circu)
            ->setCellValue('E'.ltrim((string)$fl), $diope)
            ->setCellValue('F'.ltrim((string)$fl), $r["apellidos"]." , ".$r["nombres"])
            ->setCellValue('G'.ltrim((string)$fl), $r["sexo"])
            ->setCellValue('H'.ltrim((string)$fl), $gene)
            ->setCellValue('I'.ltrim((string)$fl), $r["edac"])
            ->setCellValue('J'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
            ->setCellValue('K'.ltrim((string)$fl), $docu)
            ->setCellValue('L'.ltrim((string)$fl),rib2($r))
            ->setCellValue('M'.ltrim((string)$fl), $alta)
            ->setCellValue('N'.ltrim((string)$fl), $baja)
            ->setCellValue('O'.ltrim((string)$fl), $r["mote"])
	    ->setCellValue('P'.ltrim((string)$fl), aborrar($r["dezo"]))           
            ->setCellValue('Q'.ltrim((string)$fl), aborrar($r["tmed"]))
            ->setCellValue('R'.ltrim((string)$fl), un_campo("select deno from tablas where tipo='TJ' and valo=".nulea($r["juzgado_modalidad"])))
            ->setCellValue('S'.ltrim((string)$fl), aborrar($r["juzgado_numero"]))
            ->setCellValue('T'.ltrim((string)$fl), aborrar($r["juzgado_expediente"]))
            ->setCellValue('U'.ltrim((string)$fl), aborrar($r["juzgado_caratula"]))
            ->setCellValue('V'.ltrim((string)$fl), aborrar($r["vivi"]))
            ->setCellValue('W'.ltrim((string)$fl),aborrar(un_campo("select apellidos from grupos_legajos left join grupos on grupo=idgrupos where grupo_legajo=".$r["legajo"])))
            ->setCellValue('X'.ltrim((string)$fl),aborrar(un_campo("select deno from tablas where tipo='MISUP' and valo=".nulea($r["ming1"]))))
            ->setCellValue('Y'.ltrim((string)$fl),aborrar($r["ming1"]))
            ->setCellValue('Z'.ltrim((string)$fl),aborrar(un_campo("select deno from tablas where tipo='MISUP' and valo=".nulea($r["ming2"]))))
            ->setCellValue('AA'.ltrim((string)$fl),aborrar($r["ming2"]))
            ->setCellValue('AB'.ltrim((string)$fl),aborrar(un_campo("select deno from tablas where tipo='MISUP' and valo=".nulea($r["ming3"]))))
            ->setCellValue('AC'.ltrim((string)$fl),aborrar($r["ming3"]))
            ->setCellValue('AD'.ltrim((string)$fl),aborrar(un_campo("select deno from tablas where tipo='CTEX' and valo=".nulea($r["ctex1"]))))
            ->setCellValue('AE'.ltrim((string)$fl),aborrar(nulea($r["ctex1"])))
            ->setCellValue('AF'.ltrim((string)$fl),aborrar(un_campo("select deno from tablas where tipo='CTEX' and valo=".nulea($r["ctex2"]))))
            ->setCellValue('AG'.ltrim((string)$fl),aborrar(nulea($r["ctex2"])))
            ->setCellValue('AH'.ltrim((string)$fl),aborrar(un_campo("select deno from tablas where tipo='CTEX' and valo=".nulea($r["ctex3"]))))
            ->setCellValue('AI'.ltrim((string)$fl),aborrar(nulea($r["ctex3"])))
            ->setCellValue('AJ'.ltrim((string)$fl),aborrar(un_campo("select deno from tablas where tipo='EE' and valo=".nulea($r["es_egreso"]))))
            ->setCellValue('AK'.ltrim((string)$fl),aborrar(nulea($r["es_egreso"])))
            ->setCellValue('AL'.ltrim((string)$fl),aborrar(un_campo("select deno from tablas where tipo='ETEE' and valo=".nulea($r["es_egreso_estado"]))))
            ->setCellValue('AM'.ltrim((string)$fl),aborrar(nulea($r["es_egreso_estado"])))
            ->setCellValue('AN'.ltrim((string)$fl),si($r["decreto_5"]=="1","SI",""));
;
;
};

$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"(*) Edades al ".$_GET["hasta"]);	

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
	->setCellValue('A'.ltrim((string)($fl+2)),"Fechas Desde / Hasta ".$_GET["desde"]." - ".$_GET["hasta"])
	->setCellValue('A'.ltrim((string)($fl+3)),"Dir. Operativa ".si($diop=="0","Todas",un_campo("select deno from tablas where tipo='DIOP' and valo=".$diop)))
	->setCellValue('A'.ltrim((string)($fl+4)),"Circuito ".si($circ=="0","Red de hogares",si($circ=="1","Preingreso","ResidDGSAP")))


;
for($col='A'; $col<= 'Z'; $col++){
	ajusta($col);
};

for($col='A'; $col<= 'N'; $col++){
	ajusta('A'.$col);
};

$spreadsheet->getActiveSheet()->setTitle('Alojamientos');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Alojamientos.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;


function aborrar($t){
 return $t;
}

function ajusta($r){
global $spreadsheet;
$spreadsheet->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
}

function pertenencia($ut,$ong){
  if($ong>"0") {return "CONVENIADOS";} else {return "PROPIOS";};
  return "No Clasificado- Requiere Att";
}

?>
           