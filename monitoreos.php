<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ULTIMOS MONITOREOS REALIZADOS')
            ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'ONG')
            ->setCellValue('C2', 'Legajo')
            ->setCellValue('D2', 'Tipo Dispositivo')
            ->setCellValue('E2', 'Fecha')
            ->setCellValue('F2', 'Frecuencia')
            ->setCellValue('G2', 'Observaciones')
 	
;            
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:G2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select hogares_ong.nombre as nong, hogares_ong.legajo, dispositivos.nombre, tablas.deno, ultimo_monitoreo, frecuencia, case when ultimo_monitoreo is null then -1 else (datediff(curdate(),ultimo_monitoreo)+15)/30 end as ctrl  
from dispositivos left join hogares_ong on ong=hogares_ong.id  left join tablas on tablas.tipo='DITIP' and tablas.valo=tipo_dispositivo 
where frecuencia>0 order by tipo_dispositivo, nombre";
$conn=registros($sql);
$fl=2;
while ($r = mysqli_fetch_assoc($conn)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["nong"])
            ->setCellValue('C'.ltrim((string)$fl), $r["legajo"])
            ->setCellValue('D'.ltrim((string)$fl), $r["deno"])
            ->setCellValue('E'.ltrim((string)$fl), ffec($r["ultimo_monitoreo"]))
            ->setCellValue('F'.ltrim((string)$fl), $r["frecuencia"])
	    ->setCellValue('G'.ltrim((string)$fl), si($r["ctrl"]=="-1","Registrar fecha ultimo monitoreo",si($r["ctrl"]>$r["frecuencia"],"Urgente","")))

   ;



}
for($col='A'; $col<= 'G'; $col++){
	ajusta($col);
};
 $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
;
$spreadsheet->getActiveSheet()->setTitle('Monitoreos');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Monitoreos.xlsx';

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



           