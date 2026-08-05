<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->
    getProperties()
        ->setCreator("SURNNYA")
        ->setTitle("Nomina Casa Joven")
        ->setCategory("reportes");
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Apellido y Nombre')
            ->setCellValue('B1', 'DNI')
            ->setCellValue('C1', 'RIB')
            ->setCellValue('D1', 'Fecha Nac.')
            ->setCellValue('E1', 'Ingreso')
            ->setCellValue('F1', 'Egreso')
              ;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:F1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$reg=registros("select * from cjoven_nomina left join sujetos on cjoven_nomina.legajo=sujetos.legajo 
 order by apellidos,nombres");
   $nnya=0;
   $altas=0;
   $bajas=0;
   $fl=1;
   while($r=mysqli_fetch_assoc($reg)){
       	 $fl=$fl+1;
 	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["Apellidos"]." , ".$r["Nombres"])
            ->setCellValue('B'.ltrim((string)$fl), $r["SujetosDNI"])
 	    ->setCellValue('C'.ltrim((string)$fl), rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))	
 	    ->setCellValue('D'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
 	    ->setCellValue('E'.ltrim((string)$fl), ffec($r["alta"]))	
 	    ->setCellValue('F'.ltrim((string)$fl), ffec($r["baja"]))	
 	   ;	
         $nnya=$nnya+1;
         if(ffec($r["baja"])==""){$altas=$altas+1;}
         else{$bajas=$bajas+1;};
       
  };
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"NNYA ".$nnya);

$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Alojados ".$altas);

$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Egresados ".$bajas);

  
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),axel("Usuario ".$_SESSION["glusua"]));
	



for($col='A'; $col<= 'J'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('CasaJoven');
$spreadsheet->setActiveSheetIndex(0);
$filename="CJOVEN_nomina.xlsx";
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
           