<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1','Familias con legajo abierto en PFVFC')
            ->setCellValue('A2', axel('Descripción'))
            ->setCellValue('B2', 'Legajo')
            ->setCellValue('C2', 'Domicilio')
            ->setCellValue('D2', 'NNYA')
            ->setCellValue('E2', 'Adultos (*)')
            ->setCellValue('F2', 'NNYA S/D Edad')
            ->setCellValue('G2', 'NNYA c/FechaBaja')
  ;
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:G2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select fv_familias.*,
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_baja is null  and edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,curdate())<=17) as nnya,
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_baja is null  and edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,curdate())>17) as adul,
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_baja is null  and f_nacimiento is null and sujetosedad is null) as nnyasd,
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_baja is not null) as nnyabaja 
  from fv_familias order by descripcion";
   $reg=registros($sql);
   $fami=0;
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["descripcion"])
            ->setCellValue('B'.ltrim((string)$fl), $r["legajomanual"])
            ->setCellValue('C'.ltrim((string)$fl), $r["domicilio"])
 	    ->setCellValue('D'.ltrim((string)$fl), $r["nnya"])	
 	    ->setCellValue('E'.ltrim((string)$fl), $r["adul"])	
 	    ->setCellValue('F'.ltrim((string)$fl), $r["nnyasd"])	
 	    ->setCellValue('G'.ltrim((string)$fl), $r["nnyabaja"])	
 	    ;
        $fami=$fami+1;
  };
 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $fami." Familias")
 	    ->setCellValue('D'.ltrim((string)$fl), "=sum(D2:D".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('E'.ltrim((string)$fl), "=sum(E2:E".ltrim((string) ($fl-1)).")")	
	    ->setCellValue('F'.ltrim((string)$fl), "=sum(G2:G".ltrim((string) ($fl-1)).")")	
	    ->setCellValue('G'.ltrim((string)$fl), "=sum(G2:G".ltrim((string) ($fl-1)).")")	

 	    ;	
          
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"(*) Los adultos computados en este reporte son aquellos");
$fl=$fl+1;
   $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),utf8_encode("que fueron cargados como NNYA y cumplieron 18 o + años solamente"));
for($col='A'; $col<= 'H'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('FV-familias-gen');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'FV-familias-gen.xlsx';

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


           