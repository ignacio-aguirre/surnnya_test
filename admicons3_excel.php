<?php
// error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Apellido y Nombre')
    	->setCellValue('B1', 'Tipo y Nro.Doc.')
        ->setCellValue('C1', 'RIB')
        ->setCellValue('D1', 'Fecha Nac.')
        ->setCellValue('E1', 'Edad (hoy)')
        ->setCellValue('F1', 'Sexo')
        ->setCellValue('G1', 'Alta')
        ->setCellValue('H1', 'Dispositivo')
	    ->setCellValue('I1', 'Pertenencia')
        ->setCellValue('J1', 'Juzgado')
        ->setCellValue('K1', 'DZ/Sector')
        ->setCellValue('L1', 'Medida')
	    ->setCellValue('M1', 'Estrat.Egreso')
;
$diop=$_GET["direccion_operativa"];
$circ=$_GET["circuito"];
$hogar=$_GET["hogar"];
if($hogar!=""){$condicion=" admi_hogar=".$hogar;}
else{
  $condicion=" 1";
  if($diop!="0"){$condicion=$condicion." and  direccion_operativa=".$diop;};
  if($circ=="1"){$condicion=$condicion." and area_gubernamental=1 and  tipo_dispositivo=11";};
  if($circ=="2"){$condicion=$condicion." and area_gubernamental=1 and  tipo_dispositivo=2";};
};


$sql="select *,  
      sujetos.legajo , sujetosDNI, Apellidos, Nombres, sexo,edc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad,
      tdef.deno as dezo,tstd.deno as tdoc,utec.deno as unidad, eegr.deno as estra, case when edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate())<18 then 
           case when tipo_medida=92 then 'No Innovar' else
        case when tipo_medida=93 then 'Adoptabilidad' else 
         (select max(date_add(fecha, interval dias day)) from sujetos_medidas where sujetos_medidas.legajo=sujetos.legajo) end end
       else 'Mayor Edad' end as medida  , rib_anio, rib_numero, rib_reparticion, 
       ong    
       from hogares_admision
       	left join dispositivos on admi_hogar=dispositivos.id 
       	left join sujetos on admi_legajo=sujetos.legajo
       	left join tablas tstd on tstd.valo=sujetos.TipoDNI and tstd.tipo='TD'
       	left join sujetos_juridicos on admi_legajo=sujetos_juridicos.legajo 
       	left join tablas tdef on tdef.valo=defensoria_zonal and tdef.tipo='CM'
       	left join tablas mote on mote.valo=admi_mote and mote.tipo='HOMOE'
	left join tablas utec on utec.valo=unidad_tecnica and utec.tipo='SUPUT'
        left join tablas eegr on eegr.valo=es_egreso and eegr.tipo='EE'
	left join tablas agub on agub.valo=area_gubernamental and agub.tipo='AGUB' 
   	left join af_familias on admi_fami=idaf_familias
	where ".$condicion." and admi_alta is not null and admi_baja is null";
       	$sql=$sql." order by  unidad, nombre,af_familias.denominacion, Apellidos, Nombres";
	$conn = registros($sql);
	$f=1; 
	while ($r = mysqli_fetch_assoc($conn)) {
         $f=$f+1;
	 $sheet->setCellValue('A'.ltrim((string)$f),$r["Apellidos"]." , ".$r["Nombres"])
 			->setCellValue('B'.ltrim((string)$f),$r["tdoc"]." ".$r["SujetosDNI"])
 			->setCellValue('C'.ltrim((string)$f),rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))
 			->setCellValue('D'.ltrim((string)$f),ffec($r["f_nacimiento"]))
 			->setCellValue('E'.ltrim((string)$f),$r["edad"])
 			->setCellValue('F'.ltrim((string)$f),$r["sexo"])
 			->setCellValue('G'.ltrim((string)$f),ffec($r["admi_alta"]))
 			->setCellValue('H'.ltrim((string)$f),$r["nombre"])
 			->setCellValue('I'.ltrim((string)$f),pertenencia($r["unidad"],$r["ong"]))
 			->setCellValue('J'.ltrim((string)$f),$r["juzgado_numero"])
 			->setCellValue('K'.ltrim((string)$f),$r["dezo"])
 			->setCellValue('L'.ltrim((string)$f),si($r["medida"]=="Mayor Edad","Mayor Edad",si($r["medida"]=="No Innovar","No Innovar",si($r["medida"]=="Adoptabilidad","Adoptabilidad",ffec($r["medida"])))))
 			->setCellValue('M'.ltrim((string)$f),$r["estra"])
         ;
     };	
  
  $f=$f+1;
	 $sheet->setCellValue('A'.ltrim((string)$f),($f-2)." NNYA");
  $f=$f+1;
	 $sheet->setCellValue('A'.ltrim((string)$f),"Direccion Operativa ".si($diop=="0","Todas",un_campo("select deno from tablas where tipo='DIOP' and valo=".$diop)));
  $f=$f+1;
	$sheet->setCellValue('A'.ltrim((string)$f),"Circuito ".si($circ=="0","Red de Hogares",si($circ=="1","Preingreso","Residenciales DGSAP")));
	$f=$f+2;
    $sheet->setCellValue('A'.ltrim((string)$f),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($f+1)),"Usuario ".$_SESSION["glusua"]);
	$spreadsheet->getActiveSheet()->getStyle('A1:M1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

	for($col='A'; $col<= 'M'; $col++){
	ajusta($col);
};
$spreadsheet->getActiveSheet()->setTitle('AlojadosHoy');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Alojados-hoy.xlsx';

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
