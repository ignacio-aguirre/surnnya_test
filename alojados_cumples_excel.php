<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$anio=nget("anio");
$mes=nget("mes");
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', 'NNYA que cumplen en '.$mes.'/'.$anio)
            ->setCellValue('A2', 'RIB')
            ->setCellValue('B2', 'Doc.Identidad')
            ->setCellValue('C2', 'Apellido y Nombre')
            ->setCellValue('D2', 'Fec.Nacimiento')
            ->setCellValue('E2', 'Edad que cumple')
	    ->setCellValue('F2', 'Dispositivo Alojamiento');
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:F2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

 
$sql="select nombre, sujetos.legajo,apellidos, nombres,  rib_anio, rib_numero, rib_reparticion, sujetosdni, deno,
f_nacimiento,edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,concat($anio,'/',$mes,'/',day(f_nacimiento))) as eda from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar
 left join sujetos on admi_legajo=sujetos.legajo
 left join tablas on tipo='TD' and valo=tipodni
 where admi_alta<=curdate() and admi_baja is null and month(f_nacimiento)=".$mes." order by nombre, apellidos, nombres";
$conn=registros($sql);
$fl=2;
while ($dt = mysqli_fetch_assoc($conn)) {
 $fl=$fl+1;
 $rib=rib2($dt);
 $hoga=$dt["nombre"];                  //hogar
 $apno=$dt["apellidos"]." , ".$dt["nombres"];      //apellido, nombre
 $naci=ffec($dt["f_nacimiento"]);                 //fnac
 $docu=$dt["deno"]." ".$dt["sujetosdni"];
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $rib)
            ->setCellValue('B'.ltrim((string)$fl), $docu)
            ->setCellValue('C'.ltrim((string)$fl), $apno)
            ->setCellValue('D'.ltrim((string)$fl), $naci)
            ->setCellValue('E'.ltrim((string)$fl), $dt["eda"])
            ->setCellValue('F'.ltrim((string)$fl), $hoga)
;
};

$cant=$fl-2;
$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $cant." NNYA");

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'F'; $col++){
	ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('Cumples');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Alojados-cumples.xlsx';

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
           