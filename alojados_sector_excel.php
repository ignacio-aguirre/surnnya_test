<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$sector=nget("sector");
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'RIB')
            ->setCellValue('B1', 'Apellido y Nombre')
	    ->setCellValue('C1', 'Dispositivo Alojamiento')
            ->setCellValue('D1', 'Fec.Ingreso')
            ->setCellValue('G1', un_campo("select deno from tablas where tipo='CM' and valo=".$sector));
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:G1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   
$sql="select nombre, sujetos.legajo,apellidos, nombres,  rib_anio, rib_numero, rib_reparticion, 
admi_alta from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar
 left join sujetos on admi_legajo=sujetos.legajo
 where admi_alta<=curdate() and admi_baja is null and defensoria_zonal=".$sector." order by rib_anio,rib_numero,rib_reparticion";
$conn=registros($sql);
$fl=1;
while ($dt = mysqli_fetch_assoc($conn)) {
 $fl=$fl+1;
 $rib=rib2($dt);
 $hoga=$dt["nombre"];                  //hogar
 $apno=$dt["apellidos"]." , ".$dt["nombres"];      //apellido, nombre
 $alta=ffec($dt["admi_alta"]);                 //alta
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $rib)
            ->setCellValue('B'.ltrim((string)$fl), $apno)
            ->setCellValue('C'.ltrim((string)$fl), $hoga)
            ->setCellValue('D'.ltrim((string)$fl), $alta);
};
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'F'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Alojamientos');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Alojamientos-sector.xlsx';

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
           