<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Apellido y Nombre')
            ->setCellValue('B1', 'Tipo y Nro.Doc.')
            ->setCellValue('C1', 'RIB')
            ->setCellValue('D1', 'Fecha Nac.')
            ->setCellValue('E1', 'Edad (hoy)')
            ->setCellValue('F1', 'Sexo')
            ->setCellValue('G1', 'Alta')
            ->setCellValue('H1', 'Dispositivo')
	    ->setCellValue('I1', 'Pertenencia')
	    ->setCellValue('J1', 'Familia')
            ->setCellValue('K1', 'Juzgado')
            ->setCellValue('L1', 'DZ/Sector')
            ->setCellValue('M1', 'Medida')
            ->setCellValue('N1', 'Fam Apoyo 1')
            ->setCellValue('O1', 'Fam Apoyo 2')
            ->setCellValue('P1', 'Fam Apoyo 3')
			->setCellValue('Q1', 'F.adop.decretada')
			->setCellValue('R1', 'Cud')

;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:R1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$hogar=$_GET["dispositivo"];
$sql="select *, dispositivos.nombre as dispositivo, af_familias.denominacion as familia, 
      sujetos.legajo , sujetosDNI, Apellidos, Nombres, sexo,edc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad,
	  f_adop_decretada,cud,      tdef.deno as dezo,tstd.deno as tdoc, case when edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate())<18 then 
           case when tipo_medida=92 then 'No Innovar' else
        case when tipo_medida=93 then 'Adoptabilidad' else 
         (select max(date_add(fecha, interval dias day)) from sujetos_medidas where sujetos_medidas.legajo=sujetos.legajo) end end
       else 'Mayor Edad' end as medida  , rib_anio, rib_numero, rib_reparticion, case when ong>0 then 'CONVENIADOS' else 'PROPIOS' end as pertenencia     
       from hogares_admision
       	left join dispositivos on admi_hogar=dispositivos.id 
       	left join sujetos on admi_legajo=sujetos.legajo
       	left join tablas tstd on tstd.valo=sujetos.TipoDNI and tstd.tipo='TD'
       	left join sujetos_juridicos on admi_legajo=sujetos_juridicos.legajo 
       	left join tablas tdef on tdef.valo=defensoria_zonal and tdef.tipo='CM'
       	left join tablas mote on mote.valo=admi_mote and mote.tipo='HOMOE'
   	left join af_familias on admi_fami=idaf_familias
	where admi_alta is not null and admi_baja is null and tipo_dispositivo=1 ";
        if($hogar!='')  $sql=$sql." and admi_hogar=".$hogar;
       	$sql=$sql." order by  pertenencia, nombre,af_familias.denominacion, Apellidos, Nombres";
	$conn = registros($sql);
	$f=1; 
	while ($r = mysqli_fetch_assoc($conn)) {
         $f=$f+1;
	 $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('A'.ltrim((string)$f),$r["Apellidos"]." , ".$r["Nombres"])
 		->setCellValue('B'.ltrim((string)$f),$r["tdoc"]." ".$r["SujetosDNI"])
 		->setCellValue('C'.ltrim((string)$f),rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))
 		->setCellValue('D'.ltrim((string)$f),ffec($r["f_nacimiento"]))
 		->setCellValue('E'.ltrim((string)$f),$r["edad"])
 		->setCellValue('F'.ltrim((string)$f),$r["sexo"])
 		->setCellValue('G'.ltrim((string)$f),ffec($r["admi_alta"]))
 		->setCellValue('H'.ltrim((string)$f),$r["dispositivo"])
 		->setCellValue('I'.ltrim((string)$f),$r["pertenencia"])
 		->setCellValue('J'.ltrim((string)$f),$r["familia"])
 		->setCellValue('K'.ltrim((string)$f),$r["juzgado_numero"])
 		->setCellValue('L'.ltrim((string)$f),$r["dezo"])
 		->setCellValue('M'.ltrim((string)$f),si($r["medida"]=="Mayor Edad","Mayor Edad",si($r["medida"]=="No Innovar","No Innovar",si($r["medida"]=="Adoptabilidad","Adoptabilidad",ffec($r["medida"])))))
         ;
        $apy=registros("select af_apoyos.*,af_familias.denominacion from af_apoyos 
        left join af_familias on familia=idaf_familias where alojamiento=".$r["idhogares_admision"]." and f_hasta is null order by f_desde");
        $col=15;
	while($y=mysqli_fetch_assoc($apy)){
     	 $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr(ord("A")-2+$col).ltrim((string)$f),$y["denominacion"]);
	     $col++;	
	};
	 $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('Q'.ltrim((string)$f),ffec($r["f_adop_decretada"]))
		->setCellValue('R'.ltrim((string)$f),cud($r["cud"]));
     };	
  
  $f=$f+1;
	 $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('A'.ltrim((string)$f),($f-2)." NNYA");
	 $f=$f+2;
       $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$f),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($f+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'S'; $col++){
	ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('NNYA_SAFTHoy');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'NNYA_SAFTHoy.xlsx';

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
function cud($n){
	if($n=="0") {return "No tiene";};
	if($n=="1") {return "CUD en tramite";};
	if($n=="2") {return "Tiene CUD";};
}
?>
