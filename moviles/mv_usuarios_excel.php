<?php
session_start();
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("funciones.php");
$spreadsheet = new Spreadsheet();

$spreadsheet->setActiveSheetIndex(0)
            
            ->setCellValue('A1', 'Dispositivo')
            ->setCellValue('B1', 'Apellidos y nombres')
            ->setCellValue('C1', 'Usuario')
            ->setCellValue('D1', 'Email');
$spreadsheet->getActiveSheet()->getStyle('A1:D1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select concat(apellidos,', ',nombres) as apynombre, nombre, acronimo, movil_usuarios.email 
from movil_usuarios
left join dispositivos on dispositivo=dispositivos.id
where movil_usuarios.baja is null order by nombre,apellidos, nombres";
$reg=registros($sql);
$fl=1;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["apynombre"])
            ->setCellValue('C'.ltrim((string)$fl), $r["acronimo"])
            ->setCellValue('D'.ltrim((string)$fl), $r["email"])
            ;
};
$fl++;
$fl++;
 $spreadsheet->setActiveSheetIndex(0)
         ->setCellValue('A'.ltrim((string)$fl), "Usuario")
         ->setCellValue('B'.ltrim((string)$fl), $_SESSION["nusuario"]);
$fl++;
 $spreadsheet->setActiveSheetIndex(0)
       ->setCellValue('A'.ltrim((string)$fl), "Emitido el")
         ->setCellValue('B'.ltrim((string)$fl), $_SESSION["hoy_v"]);

 
for($col='A'; $col<= 'D'; $col++){
    ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('UsuariosMv');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'UsuariosMv.xlsx';
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

           