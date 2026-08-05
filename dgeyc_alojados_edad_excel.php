<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$anio=$_GET["anio"];
$fhas=fsql("31/12/".$anio);

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NNYA Alojados en Hogares o con Familias de Acogimiento por Grupo de Edad '.$anio)
            ->setCellValue('B2', 'Hasta 6')
            ->setCellValue('C2', '7-12')
            ->setCellValue('D2', '13-17')
            ->setCellValue('E2', '18 o +')
            ->setCellValue('F2', 'Total');
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:F2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$r=un_registro("select sum(case when edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.")<=6 then 1 else 0 end) as h6,
 sum(case when edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.") between 7 and 12 then 1 else 0 end) as h12,
 sum(case when edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.") between 13 and 17 then 1 else 0 end) as h17,
 sum(case when edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.") >17 then 1 else 0 end) as hmas
 FROM sujetos where sujetos.legajo in (select distinct admi_legajo from hogares_admision where admi_alta is not null and year(admi_alta)<=".$anio." and (admi_baja is null or year(admi_baja)>=".$anio."))");
$fl=3;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B'.ltrim((string)$fl), $r["h6"])
            ->setCellValue('C'.ltrim((string)$fl), $r["h12"])
            ->setCellValue('D'.ltrim((string)$fl), $r["h17"])
            ->setCellValue('E'.ltrim((string)$fl), $r["hmas"])
            ->setCellValue('F'.ltrim((string)$fl), ($r["h6"]+$r["h12"]+$r["h17"]+$r["hmas"]))
;



$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)	->setCellValue('A'.ltrim((string)$fl),"Edades calculadas al 31/12/".$anio);
for($col='A'; $col<= 'F'; $col++){
	ajusta($col);
};
$spreadsheet->setActiveSheetIndex(0);
$spreadsheet->getActiveSheet()->setTitle('Cantidades');
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A1', 'NNYA Alojados en Hogares o con Familias de Acogimiento '.$anio)
            ->setCellValue('B2', 'RIB')
            ->setCellValue('C2', 'Apellido y Nombre')
            ->setCellValue('D2', 'Edad');
$spreadsheet->setActiveSheetIndex(1)->getStyle('A1:D2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

  $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
    ->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);

$reg=registros("select rib_anio,rib_numero,rib_reparticion,apellidos,nombres,edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.") as eda
 FROM sujetos   where sujetos.legajo in (select distinct admi_legajo from hogares_admision  where admi_alta is not null and year(admi_alta)<=".$anio." and (admi_baja is null or year(admi_baja)>=".$anio.")) order by eda, apellidos, nombres");
$fl=2;
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('B'.ltrim((string)$fl), rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))
            ->setCellValue('C'.ltrim((string)$fl), $r["apellidos"]." , ".$r["nombres"])
            ->setCellValue('D'.ltrim((string)$fl), $r["eda"]);

};


for($col='A'; $col<= 'F'; $col++){
	ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('Alojados-edad');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Alojado-edads.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

exit;

function ajusta($r){
global $spreadsheet;
$spreadsheet->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
}

?>
           