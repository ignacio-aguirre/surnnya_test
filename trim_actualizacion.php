<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$desde=ffec(un_campo("select date_add(curdate(),INTERVAL -4 MONTH) from dual"));
$hasta=ffec(un_campo("select curdate() from dual"));
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'hogar')
            ->setCellValue('B1', 'legajo')
            ->setCellValue('C1', 'Apellidos')
            ->setCellValue('D1', 'Nombres')
            ->setCellValue('E1', 'Sexo')
            ->setCellValue('G1', 'Nacimiento')
            ->setCellValue('H1', 'Tipodoc')
            ->setCellValue('I1', 'Numedoc')
            ->setCellValue('L1', 'Alta')
            ->setCellValue('M1', 'Baja')
            ->setCellValue('P1', 'DefZonal')
            
     
;

$sql1="admi_hogar, sujetos.legajo,apellidos, nombres, sexo, f_nacimiento, tbtd.deno as tdoc, sujetosdni as ndoc, concat('RIB-',rib_anio,'-',rib_numero, '-', rib_reparticion) as rib , 
admi_alta, admi_baja, defensoria_zonal ";
$sql="select ".$sql1." from hogares_admision 
 left join sujetos on admi_legajo=sujetos.legajo 
 left join sujetos_juridicos on sujetos_juridicos.legajo=admi_legajo 
 left join tablas as tbtd on tbtd.tipo='TD' and tipoDni=tbtd.valo 
 where admi_alta<=".fsql($hasta)." and (admi_baja is null or admi_baja>=".fsql($desde).") order by admi_hogar, sujetos.legajo";
$conn=registros($sql);
$fl=1;
while ($dt = mysqli_fetch_assoc($conn)) {
 $fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $dt["admi_hogar"])
            ->setCellValue('B'.ltrim((string)$fl), $dt["legajo"])
            ->setCellValue('C'.ltrim((string)$fl), axel($dt["apellidos"]))
            ->setCellValue('D'.ltrim((string)$fl), axel($dt["nombres"]))
            ->setCellValue('E'.ltrim((string)$fl), $dt["sexo"])
            ->setCellValue('G'.ltrim((string)$fl), axel(ffec($dt["f_nacimiento"])))
            ->setCellValue('H'.ltrim((string)$fl), axel($dt["tdoc"]))
            ->setCellValue('I'.ltrim((string)$fl), $dt["ndoc"])
            ->setCellValue('L'.ltrim((string)$fl), axel(ffec($dt["admi_alta"])))
            ->setCellValue('M'.ltrim((string)$fl), axel(ffec($dt["admi_baja"])))
            ->setCellValue('P'.ltrim((string)$fl), axel($dt["defensoria_zonal"]));
};
         

$spreadsheet->getActiveSheet()->setTitle('ExpoNNYA');
$spreadsheet->setActiveSheetIndex(0);

$filename = 'expo_nnya.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('intercambio/'.$filename);
Redirect("porfavor?url=importa_nnya");
exit;


?>



           