<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Apellidos y nombres')
            ->setCellValue('B1', 'Dispositivo')
            ->setCellValue('C1', 'Ingreso')
            ->setCellValue('D1', 'Egreso')
            ->setCellValue('E1', 'Ds.Permanencia');
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:E1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $desde=fsql(ffec($_GET["desde"]));
   $hasta=fsql(ffec($_GET["hasta"]));
   $do=nget("direccion_operativa");
   $sql="select  nombre, apellidos, nombres,admi_alta, admi_baja , datediff(case when admi_baja is null or admi_baja>".$hasta." then ".$hasta." else admi_baja end,admi_alta) as dias 
  from hogares_admision h1 left join dispositivos on h1.admi_hogar=dispositivos.id 
  left join sujetos on h1.admi_legajo=sujetos.legajo 
  where h1.admi_alta <= ".$hasta." and (h1.admi_baja is null or h1.admi_baja>".$hasta.") and direccion_operativa=".$do." order by nombre, admi_alta,apellidos, nombres";
  $reg=registros($sql);
  $fl=1;
  while($r=mysqli_fetch_assoc($reg)){
   $fl=$fl+1;
	 $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
      ->setCellValue('A'.ltrim((string)$fl), $r["apellidos"]." , ".$r["nombres"])
 	    ->setCellValue('C'.ltrim((string)$fl), ffec($r["admi_alta"]))	
 	    ->setCellValue('D'.ltrim((string)$fl), ffec($r["admi_baja"]))	
      ->setCellValue('E'.ltrim((string)$fl),$r["dias"] );	
         

  };
 
  $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
	->setCellValue('A'.ltrim((string)($fl+2)),"Fechas Desde / Hasta ".ffec($_GET["desde"])." - ".ffec($_GET["hasta"]));
  $fl=$fl+3;
  if($do=="1"){
  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A'.ltrim((string)($fl)),"Dir. operativa: Adolescencias");
  }else{
  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A'.ltrim((string)($fl)),"Dir. operativa: Infancias");
  };
  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A'.ltrim((string)($fl+1)),utf8_encode("El cálculo de permanencia considera  desde la fecha de ingreso")); 
  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A'.ltrim((string)($fl+2)), 
  "hasta la menor fecha entre egreso y ".ffec($_GET["hasta"]));
for($col='A'; $col<= 'E'; $col++){
	ajusta($col);
};



$spreadsheet->getActiveSheet()->setTitle('Permanencia');
$spreadsheet->setActiveSheetIndex(0);
$filename="Permanencia-do.xlsx";
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
           