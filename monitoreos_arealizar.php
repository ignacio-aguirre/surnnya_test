<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'MONITOREOS A REALIZAR')
            ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'ONG')
            ->setCellValue('C2', 'Tipo de Dispositivo')
            ->setCellValue('D2', 'Domicilio')
            ->setCellValue('E2', 'Localidad')
            ->setCellValue('F2', 'Barrio')
            ->setCellValue('G2', 'Telefono')
            ->setCellValue('H2', 'Email')
            ->setCellValue('I2', 'Referente')
            ->setCellValue('J2', 'Celular Referente')
            ->setCellValue('K2', 'Frecuencia')
            ->setCellValue('L2', 'Ultimo Monitoreo')
            ->setCellValue('M2', 'Control');            
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:M2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select  dispositivos.*, hogares_ong.nombre as dong, tdis.deno as td, case when ultimo_monitoreo is null then -1 else (datediff(curdate(),ultimo_monitoreo)+15)/30 end as ctrl    
from dispositivos 
left join hogares_ong on ong=hogares_ong.id  
left join tablas tdis on tdis.tipo='DITIP' and tdis.valo=tipo_dispositivo
where dispositivos.baja is null and frecuencia>0 having (ctrl=-1 or ctrl>frecuencia)  
order by td,nombre";
$conn=registros($sql);
$fl=2;
while ($r = mysqli_fetch_assoc($conn)) {
 $fl=$fl+1;
 $ong=$r["dong"];
 $hoga=$r["nombre"];
 $tipo=$r["td"];
 $domi=$r["domicilio"]." ".$r["piso_departamento"];
 $loca=$r["localidad"];
 $barr=$r["barrio"];
 $tele=$r["telefonos"];
 $mail=strtolower($r["Hogares_Mail"]);
 $resp=$r["referente"];
 $celu=$r["celular_referente"];
 $frec=$r["frecuencia"];
 $ulti=ffec($r["ultimo_monitoreo"]);
 $ctrl=$r["ctrl"];
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $hoga)
            ->setCellValue('B'.ltrim((string)$fl), $ong)
            ->setCellValue('C'.ltrim((string)$fl), $tipo)
            ->setCellValue('D'.ltrim((string)$fl), $domi)
            ->setCellValue('E'.ltrim((string)$fl), $loca)
            ->setCellValue('F'.ltrim((string)$fl), $barr)
            ->setCellValue('G'.ltrim((string)$fl), $tele)
            ->setCellValue('H'.ltrim((string)$fl), $mail)
            ->setCellValue('I'.ltrim((string)$fl), $resp)
            ->setCellValue('J'.ltrim((string)$fl), $celu)
            ->setCellValue('K'.ltrim((string)$fl), $frec)
            ->setCellValue('L'.ltrim((string)$fl), $ulti)
            ->setCellValue('M'.ltrim((string)$fl), $ctrl)

   ;
}
for($col='A'; $col<= 'M'; $col++){
	ajusta($col);
};
 $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
;
$spreadsheet->getActiveSheet()->setTitle('MonitoreosPendientes');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Monitoreos-arealizar.xlsx';

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



           