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
;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:I1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$hogar="";
if(isset($_GET["hogar"])) $hogar=$_GET["hogar"];
if($hogar!=""){$condicion=" admi_hogar=".$hogar;}
else{
  $condicion=" tipo_dispositivo=12 ";
};


$sql="select *,  
      sujetos.legajo , sujetosDNI, Apellidos, Nombres, sexo,edc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad,
      tstd.deno as tdoc, rib_anio, rib_numero, rib_reparticion,        ong    
       from hogares_admision
       	left join dispositivos on admi_hogar=dispositivos.id 
       	left join sujetos on admi_legajo=sujetos.legajo
       	left join tablas tstd on tstd.valo=sujetos.TipoDNI and tstd.tipo='TD'
       	left join tablas mote on mote.valo=admi_mote and mote.tipo='HOMOE'
	where ".$condicion." and admi_alta is not null and admi_baja is null";
       	$sql=$sql." order by  nombre, Apellidos, Nombres";
	$conn = registros($sql);
	$f=1; 
	while ($r = mysqli_fetch_assoc($conn)) {
         $f=$f+1;
	 $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('A'.ltrim((string)$f),reemplaza($r["Apellidos"])." , ".$r["Nombres"])
 		->setCellValue('B'.ltrim((string)$f),$r["tdoc"]." ".$r["SujetosDNI"])
 		->setCellValue('C'.ltrim((string)$f),rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))
 		->setCellValue('D'.ltrim((string)$f),ffec($r["f_nacimiento"]))
 		->setCellValue('E'.ltrim((string)$f),$r["edad"])
 		->setCellValue('F'.ltrim((string)$f),$r["sexo"])
 		->setCellValue('G'.ltrim((string)$f),ffec($r["admi_alta"]))
 		->setCellValue('H'.ltrim((string)$f),$r["nombre"])
 		->setCellValue('I'.ltrim((string)$f),pertenencia($r["ong"]))
         ;
     };	
  
  $f=$f+1;
	 $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('A'.ltrim((string)$f),($f-2)." NNYA");
	 $f=$f+2;
       $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$f),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($f+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'I'; $col++){
	ajusta($col);
};
$spreadsheet->getActiveSheet()->setTitle('AlojadosHoy');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'PAE-AlojadosHoy.xlsx';
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

function pertenencia($ong){
  if($ong>"0") {return "CONVENIADOS";} else {return "PROPIOS";};
  return "No Clasificado- Requiere Att";
}
          
?>
