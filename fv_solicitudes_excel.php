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
            ->setCellValue('B1', 'Solicitudes de Intervencion a PFVFyC desde el '.$_GET["desde"]." hasta el ".$_GET["hasta"])
            ->setCellValue('A2', 'Fecha Ingreso')
            ->setCellValue('B2', 'Derivante')
            ->setCellValue('C2', 'Expediente')
	    ->setCellValue('D2', 'Legajo')
            ->setCellValue('E2', 'Grupo Familiar')
            ->setCellValue('F2', 'Int.Previas')
            ->setCellValue('G2', 'Domicilio')
            ->setCellValue('H2', 'P/Asignar')
            ->setCellValue('I2', utf8_encode('Asignación'))
            ->setCellValue('J2', 'Centro Zonal')
            ->setCellValue('K2', 'Cese')
            ->setCellValue('L2', 'Rechazo')
            ->setCellValue('M2', utf8_encode('Cancelación'))
            ->setCellValue('N2', utf8_encode('Articulación'))
            ->setCellValue('O2', 'Informe/CCOO')
            ->setCellValue('P2', 'ESTADO '.$_GET["hasta"])
  ;
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:P2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select fv_familias.*,fv_participaciones.*,sectores.denominacion, tderi.info,
   estado_sol(".$desde.",".$hasta.",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion) as estado
  from fv_participaciones left join fv_familias on familia=idfv_familias left join sectores on efector=sectores.id  
  left join tablas tderi on tderi.tipo='CM' and tderi.valo=derivante
 where fecha_ingreso between ".$desde." and ".$hasta." order by fecha_ingreso";
   $reg=registros($sql);
   $fami=0;
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["fecha_ingreso"]))
            ->setCellValue('B'.ltrim((string)$fl), si($r["info"]=="",$r["derivante_especificar"],$r["info"]))
            ->setCellValue('C'.ltrim((string)$fl), $r["expediente"])
            ->setCellValue('D'.ltrim((string)$fl), $r["legajomanual"])
            ->setCellValue('E'.ltrim((string)$fl), $r["descripcion"])
            ->setCellValue('F'.ltrim((string)$fl), si($r["solicitudes_previas"]=="1","SI","NO"))
            ->setCellValue('G'.ltrim((string)$fl), $r["domicilio"])
            ->setCellValue('H'.ltrim((string)$fl), ffec($r["fecha_condiciones"]))
 	    ->setCellValue('I'.ltrim((string)$fl), ffec($r["fecha_asignacion"]))
            ->setCellValue('J'.ltrim((string)$fl), $r["denominacion"])
 	    ->setCellValue('K'.ltrim((string)$fl), ffec($r["fecha_baja"]))
 	    ->setCellValue('L'.ltrim((string)$fl), ffec($r["fecha_rechazo"]))
 	    ->setCellValue('M'.ltrim((string)$fl), ffec($r["fecha_cancelacion"]))
 	    ->setCellValue('N'.ltrim((string)$fl), ffec($r["fecha_articulacion"]))
 	    ->setCellValue('O'.ltrim((string)$fl), $r["ccoo_asignacion"])
 	    ->setCellValue('P'.ltrim((string)$fl), $r["estado"])
 	    ;
        $fami=$fami+1;
  };
 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $fami." Solicitudes")
 	    ;	
          
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 



for($col='A'; $col<= 'P'; $col++){
	ajusta($col);
};
$spreadsheet->getActiveSheet()->setTitle('FV-solicitudes');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'FV-solicitudes.xlsx';

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
           