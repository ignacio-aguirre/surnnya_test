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
            ->setCellValue('B1', 'Grupos Familiares activos PFVFyC Desde el '.$_GET["desde"]." al ".$_GET["hasta"])
	    ->setCellValue('A2', 'Legajo')
            ->setCellValue('B2', 'Grupo Familiar')
            ->setCellValue('C2', 'NNYA')
            ->setCellValue('D2', 'NNYA+17')
            ->setCellValue('E2', 'NNYA S/D Edad')
            ->setCellValue('F2', 'Adultos Convivientes')
            ->setCellValue('G2', 'Adultos No Convivientes')
            ->setCellValue('H2', 'Domicilio')
            ->setCellValue('I2', 'Centro Zonal')
            ->setCellValue('J2', utf8_encode('Estado Solicitud'))
  ;
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:J2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select fv_familias.*,fv_participaciones.*,sectores.denominacion, datediff(case when fecha_baja is null then curdate() else fecha_baja end,fecha_asignacion) as dias,  
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_alta<=".$hasta." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>".$desde.") and fv_familias_miembros.legajo is not null and edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,".$hasta.")<=17) as nnya,
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_alta<=".$hasta." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>".$desde.") and fv_familias_miembros.legajo is not null and edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,".$hasta.")>17) as nnya18,
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_alta<=".$hasta." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>".$desde.") and fv_familias_miembros.legajo is not null and edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,".$hasta.") is null) as nnyasd,
  estado_sol(".$desde.",".$hasta.", fecha_articulacion,fecha_rechazo,fecha_asignacion,fecha_baja,fecha_ingreso,fecha_cancelacion) as estado
  from fv_participaciones left join fv_familias on familia=idfv_familias left join sectores on efector=sectores.id 
  where estado_sol(".$desde.",".$hasta.", fecha_articulacion,fecha_rechazo,fecha_asignacion,fecha_baja,fecha_ingreso,fecha_cancelacion)<>'NUL' 
  order by descripcion";
  $reg=registros($sql);
  $fami=0;
  $fl=2;
  while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
        $adul=intval($r["adultos_convivientes"]);
        $adnc=intval($r["adultos_noconvivientes"]);
    	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["legajomanual"])
            ->setCellValue('B'.ltrim((string)$fl), $r["descripcion"])
 	    ->setCellValue('C'.ltrim((string)$fl), $r["nnya"])	
 	    ->setCellValue('D'.ltrim((string)$fl), $r["nnya18"])	
 	    ->setCellValue('E'.ltrim((string)$fl), $r["nnyasd"])	
 	    ->setCellValue('F'.ltrim((string)$fl), $adul)	
 	    ->setCellValue('G'.ltrim((string)$fl), $adnc)	
            ->setCellValue('H'.ltrim((string)$fl), $r["domicilio"])
            ->setCellValue('I'.ltrim((string)$fl), $r["denominacion"])
 	    ->setCellValue('J'.ltrim((string)$fl),$r["estado"])
 	    ;
        $fami=$fami+1;
  };
 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $fami." Solicitudes")
 	    ->setCellValue('C'.ltrim((string)$fl), "=sum(C3:C".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('D'.ltrim((string)$fl), "=sum(D3:D".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('E'.ltrim((string)$fl), "=sum(E3:E".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('F'.ltrim((string)$fl), "=sum(F3:F".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('G'.ltrim((string)$fl), "=sum(G3:G".ltrim((string) ($fl-1)).")")	
 	    ;	
          
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 



for($col='A'; $col<= 'J'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('FV-grupos');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'FV-grupos.xlsx';

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
           