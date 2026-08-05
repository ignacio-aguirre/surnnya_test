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
            ->setCellValue('B1', 'Ausentismo a atenciones del Gabinete de Salud Desde el '.$_GET["desde"]." al ".$_GET["hasta"])
            ->setCellValue('A2', 'Fecha Atencion')
            ->setCellValue('B2', 'Dispositivo')
            ->setCellValue('C2', 'Apellido y Nombre NNYA')
	    ->setCellValue('D2', 'Profesion')
            ->setCellValue('E2', 'Tipo de Accion')
            ->setCellValue('F2', 'Observaciones')
            ->setCellValue('G2', 'Estado');
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:G2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
          
  $sql="select es_acciones.*, nombre, espe.deno as prof, apellidos, nombres, tias.deno as tiac,tiea.deno as esta   
 from es_acciones left join es_participaciones on es_acciones.solicitud=es_participaciones.id left join dispositivos on dispositivo=dispositivos.id
 left join tablas espe on espe.tipo='ESESP' and espe.valo=es_participaciones.especialidad 
 left join tablas tias on tias.tipo='ESTIA' and tias.valo=es_acciones.tipo
 left join tablas tiea on tiea.tipo='ESEA' and tiea.valo=es_acciones.estado

 left join sujetos on es_participaciones.legajo=sujetos.legajo 
where fecha between ".$desde." and ".$hasta." and estado in(3,4,5) order by nombre, espe.deno, apellidos, nombres";

   $reg=registros($sql);
   $cant=0;
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
 	$cant=$cant+1;
       $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["fecha"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('C'.ltrim((string)$fl), si($r["legajo"]>0,$r["apellidos"].", ".$r["nombres"],""))
            ->setCellValue('D'.ltrim((string)$fl), $r["prof"])
	    ->setCellValue('E'.ltrim((string)$fl), $r["tiac"])
	    ->setCellValue('F'.ltrim((string)$fl), $r["observaciones"])
	    ->setCellValue('G'.ltrim((string)$fl), $r["esta"])

 	    ;
  };
     $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $cant." Registros")
 	    ;	
          
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 



for($col='A'; $col<= 'G'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Ausentismo');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'GS-ausentismo.xlsx';

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
           