<?php 
// error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Pedido')
        ->setCellValue('B1', 'Categoria')
        ->setCellValue('C1', 'Admisor')
        ->setCellValue('D1', 'Apellido y Nombre')
        ->setCellValue('E1', 'Edad (hoy)')
        ->setCellValue('F1', 'Solicitante')
        ->setCellValue('G1', 'Sit.Socio Habitacional')
        ->setCellValue('H1', 'Motivo')
        ->setCellValue('I1', 'Etapa')
        ->setCellValue('J1', 'Hogar')
        ->setCellValue('K1', 'Desde el')
;

$sql="select hogares_admision.*, datediff(curdate(),admi_fped) as dife, sujetos.legajo , sujetos.Apellidos as apel, Nombres, 
 edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as edad_calc,sujetosmeses,hogares_ca.deno as cate, 
 case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else 
   concat(hogares_dz.deno,
    case when hogares_dz.info>'' then concat('-',hogares_dz.info) 
        else '' 
    end,
    case when admi_deriv_cual >'' 
     then concat('-',admi_deriv_cual)  
    else '' end) 
  end as deriv ,  
   concat(hogares_proc.deno,' ',admi_proc_cual) as proc, ming.deno as moti, 
 etapas.deno as eta, nombre from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo 
    left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' 
    left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' 
    left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH' 
    left join tablas ming on ming.tipo='HOMOI' and admi_moti=ming.valo 
    left join tablas etapas on etapa=etapas.valo and etapas.tipo='ADEV'
    left join dispositivos on dispositivos.id=admi_hogar
    left join tablas hogares_dz on hogares_dz.tipo='CM' and hogares_dz.valo=admi_deriv_sector 
    where admi_fderiv is null and admi_fped is not null and admi_alta is null and admi_susp is null order by  apel, Nombres";
$conn=registros($sql);
$fl=1;
while ($da = mysqli_fetch_assoc($conn)) {
 $fl=$fl+1;
 $sheet->setCellValue('A'.ltrim((string)$fl), ffec($da["admi_fped"]))
        ->setCellValue('B'.ltrim((string)$fl), strtolower($da["cate"]))
        ->setCellValue('C'.ltrim((string)$fl), strtolower($da["admi_admi"]))
        ->setCellValue('D'.ltrim((string)$fl), $da["apel"]." , ".$da["Nombres"])
        ->setCellValue('E'.ltrim((string)$fl), $da["edad_calc"])
        ->setCellValue('F'.ltrim((string)$fl), $da["deriv"])
        ->setCellValue('G'.ltrim((string)$fl), strtolower($da["proc"]))
        ->setCellValue('H'.ltrim((string)$fl), $da["moti"])
        ->setCellValue('I'.ltrim((string)$fl), $da["eta"])
        ->setCellValue('J'.ltrim((string)$fl), $da["nombre"])
        ->setCellValue('K'.ltrim((string)$fl), ffec($da["fecha_etapa"]))
;


};
$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
for($col='A'; $col<= 'K'; $col++){
	ajusta($col);
};
$sheet->setTitle('VacantesaAsignar');
$filename = 'Vacantes-asignar.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
function ajusta($col){
    global $spreadsheet;
    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);    
}

?>



           