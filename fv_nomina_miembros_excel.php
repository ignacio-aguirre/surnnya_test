<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', utf8_encode('NNYA por Grupo Familiar con Intervención o Solicitud'))
            ->setCellValue('B1', $_GET['desde'])
            ->setCellValue('C1', $_GET['hasta'])
            ->setCellValue('A2', 'Fecha Ingreso')
            ->setCellValue('B2', 'Legajo')
            ->setCellValue('C2', 'Grupo Familiar')
            ->setCellValue('D2', 'Apellidos')
            ->setCellValue('E2', 'Nombres')
            ->setCellValue('F2', 'DNI')
            ->setCellValue('G2', 'RIB')
            ->setCellValue('H2', 'F.Nacimiento')
	    ->setCellValue('I2', 'Edad (a fecha-hasta)')
            ->setCellValue('J2', utf8_encode('Género'))
	    ->setCellValue('K2', 'Centro Zonal')
	    ->setCellValue('L2', 'Estado Solicitud')
   ;
   $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:L2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select fv_participaciones.*,fv_familias.descripcion,fv_familias.domicilio,fv_familias.legajomanual,sujetos.apellidos, sujetos.nombres,sujetos.f_nacimiento,
   sujetos.sujetosdni,rib_anio, rib_numero,rib_reparticion, sujetos.sexo,  
   edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,".fget("hasta").") as edad, sectores.denominacion,estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion) as estado     
  from fv_familias_miembros left join fv_familias on fv_familias_miembros.familia=idfv_familias 
  left join fv_participaciones on idfv_familias=fv_participaciones.familia
  left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
  left join sectores on efector=sectores.id 
  where fv_participaciones.familia>0 and fv_familias_miembros.fecha_alta<=".fget("hasta")." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>=".fget("hasta").
  ") and estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion)<>'NUL' order by descripcion,fecha_ingreso,apellidos,nombres ";
   $reg=registros($sql);
   $nnya=0;
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
	 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
 	    ->setCellValue('A'.ltrim((string)$fl), ffec($r["fecha_ingreso"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["legajomanual"])
            ->setCellValue('C'.ltrim((string)$fl), $r["descripcion"])
            ->setCellValue('D'.ltrim((string)$fl), utf8_encode(utf8_decode($r["apellidos"])))
            ->setCellValue('E'.ltrim((string)$fl), utf8_encode(utf8_decode($r["nombres"])))
 	    ->setCellValue('F'.ltrim((string)$fl), $r["sujetosdni"])	
 	    ->setCellValue('G'.ltrim((string)$fl), rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))	
 	    ->setCellValue('H'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
 	    ->setCellValue('I'.ltrim((string)$fl), si($r["edad"]=="","S/D",$r["edad"]))
 	    ->setCellValue('J'.ltrim((string)$fl), $r["sexo"])
 	    ->setCellValue('K'.ltrim((string)$fl), $r["denominacion"])
 	    ->setCellValue('L'.ltrim((string)$fl), $r["estado"])
 	    ;	
         $nnya=$nnya+1;
  };
  
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),utf8_encode("Usuario ".$_SESSION["glusua"]));
	



for($col='A'; $col<= 'L'; $col++){
	ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('FV-miembros');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'FV-miembros.xlsx';

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
           