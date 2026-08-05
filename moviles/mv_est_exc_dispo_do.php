<?php
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
include("funciones.php");
$fini=$_GET["fini"];
$ffin=$_GET["ffin"];
$reg=registros("select case when dispositivo=0 then sectores.denominacion else dispositivos.nombre end as solicitante, count(*) as cantidad, sum(valor_calculado) as pesos,
    sum(case when tipo_movil=1 then 1 else 0 end) as cant1,
    sum(case when tipo_movil=1 then valor_calculado else 0 end) as pesos1,
    sum(case when tipo_movil=2 then 1 else 0 end) as cant2,
    sum(case when tipo_movil=2 then valor_calculado else 0 end) as pesos2,
    sum(case when tipo_movil=3 then 1 else 0 end) as cant3,
    sum(case when tipo_movil=3 then valor_calculado else 0 end) as pesos3,
    sum(case when tipo_movil=4 then 1 else 0 end) as cant4,
    sum(case when tipo_movil=4 then valor_calculado else 0 end) as pesos4,
    sum(case when tipo_movil=5 then 1 else 0 end) as cant5,
    sum(case when tipo_movil=5 then valor_calculado else 0 end) as pesos5,
    sum(case when tipo_movil=6 then 1 else 0 end) as cant6,
    sum(case when tipo_movil=6 then valor_calculado else 0 end) as pesos6,
    sum(case when tipo_movil=7 then 1 else 0 end) as cant7,
    sum(case when tipo_movil=7 then valor_calculado else 0 end) as pesos7
    from movil_viajes 
    left join dispositivos on movil_viajes.dispositivo=dispositivos.id 
    left join sectores on movil_viajes.sector=sectores.id 
    where movil_viajes.fecha between ".$fini." and ".$ffin." and movil_viajes.bandeja =7     and (estado='APR' or (estado='CAN' and cancelado=1)) group by case when dispositivo=0 then sectores.denominacion else dispositivos.nombre end  order by solicitante");

 $rtot=un_registro("select 'T O T A L E S' as solicitante, count(*) as cantidad, sum(valor_calculado) as pesos,
       sum(case when tipo_movil=1 then 1 else 0 end) as cant1,
    sum(case when tipo_movil=1 then valor_calculado else 0 end) as pesos1,
    sum(case when tipo_movil=2 then 1 else 0 end) as cant2,
    sum(case when tipo_movil=2 then valor_calculado else 0 end) as pesos2,
    sum(case when tipo_movil=3 then 1 else 0 end) as cant3,
    sum(case when tipo_movil=3 then valor_calculado else 0 end) as pesos3,
    sum(case when tipo_movil=4 then 1 else 0 end) as cant4,
    sum(case when tipo_movil=4 then valor_calculado else 0 end) as pesos4,
    sum(case when tipo_movil=5 then 1 else 0 end) as cant5,
    sum(case when tipo_movil=5 then valor_calculado else 0 end) as pesos5,
    sum(case when tipo_movil=6 then 1 else 0 end) as cant6,
    sum(case when tipo_movil=6 then valor_calculado else 0 end) as pesos6,
    sum(case when tipo_movil=7 then 1 else 0 end) as cant7,
    sum(case when tipo_movil=7 then valor_calculado else 0 end) as pesos7
 
   from movil_viajes where movil_viajes.fecha between ".$fini." and ".$ffin." and movil_viajes.bandeja =7     and (estado='APR' or (estado='CAN' and cancelado=1))") ;
 $rsg=registros("select tipo_movil, movil_renglones.nombre, empr.deno,sum(movil_viajes.sg) as cant from movil_viajes left join movil_renglones on movil_renglones.id=movil_viajes.tipo_movil
    left join tablas as empr on empr.tipo='ETRA' and empr.valo=movil_viajes.empresa
    where movil_viajes.fecha between ".$fini." and ".$ffin." and movil_viajes.bandeja =7     and (estado='APR' or (estado='CAN' and cancelado=1)) group by tipo_movil,movil_renglones.nombre,empr.deno order by deno,tipo_movil");
 $rsgt=un_registro("select 'T O T A L' as nombre,sum(movil_viajes.sg) as cant from movil_viajes 
    where movil_viajes.fecha between ".$fini." and ".$ffin." and movil_viajes.bandeja =7     and (estado='APR' or (estado='CAN' and cancelado=1))");

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()
        ->setCreator("SURNNYA");
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Viajes por Solicitante')
            ->setCellValue('C1', 'desde '.sqlf($fini))
            ->setCellValue('E1', 'hasta '.sqlf($ffin));
 
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Solicitante')
            ->setCellValue('B2', 'Cantidad')
            ->setCellValue('C2', 'Pesos')
            ->setCellValue('D2', 'Cant R1')
            ->setCellValue('E2', 'Pesos R1')
            ->setCellValue('F2', 'Cant R2')
            ->setCellValue('G2', 'Pesos R2')
            ->setCellValue('H2', 'Cant R3')
            ->setCellValue('I2', 'Pesos R3')
            ->setCellValue('J2', 'Cant R4')
            ->setCellValue('K2', 'Pesos R4')
            ->setCellValue('L2', 'Cant R5')
            ->setCellValue('M2', 'Pesos R5')
            ->setCellValue('N2', 'Cant R6')
            ->setCellValue('O2', 'Pesos R6')
            ->setCellValue('P2', 'Cant R7')
            ->setCellValue('Q2', 'Pesos R7')          
;
$spreadsheet->getActiveSheet()->getStyle('A1:Q2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$fl=3;
while($r=mysqli_fetch_assoc($reg)){
 $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.ltrim((string)$fl),$r["solicitante"])
    ->setCellValue('B'.ltrim((string)$fl),$r["cantidad"])
    ->setCellValue('C'.ltrim((string)$fl), $r["pesos"]) 
    ->setCellValue('D'.ltrim((string)$fl), $r["cant1"])
    ->setCellValue('E'.ltrim((string)$fl), $r["pesos1"])
    ->setCellValue('F'.ltrim((string)$fl), $r["cant2"])
    ->setCellValue('G'.ltrim((string)$fl), $r["pesos2"])
    ->setCellValue('H'.ltrim((string)$fl), $r["cant3"])
    ->setCellValue('I'.ltrim((string)$fl), $r["pesos3"])
    ->setCellValue('J'.ltrim((string)$fl), $r["cant4"])
    ->setCellValue('K'.ltrim((string)$fl), $r["pesos4"])
    ->setCellValue('L'.ltrim((string)$fl), $r["cant5"])
    ->setCellValue('M'.ltrim((string)$fl), $r["pesos5"])
    ->setCellValue('N'.ltrim((string)$fl), $r["cant6"])
    ->setCellValue('O'.ltrim((string)$fl), $r["pesos6"])
    ->setCellValue('P'.ltrim((string)$fl), $r["cant7"])
    ->setCellValue('Q'.ltrim((string)$fl), $r["pesos7"])

;
$fl++; 
};

$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.ltrim((string)$fl),$rtot["solicitante"])
    ->setCellValue('B'.ltrim((string)$fl),$rtot["cantidad"])
    ->setCellValue('C'.ltrim((string)$fl),$rtot["pesos"]) 
    ->setCellValue('D'.ltrim((string)$fl), $rtot["cant1"])
    ->setCellValue('E'.ltrim((string)$fl), $rtot["pesos1"])
    ->setCellValue('F'.ltrim((string)$fl), $rtot["cant2"])
    ->setCellValue('G'.ltrim((string)$fl), $rtot["pesos2"])
    ->setCellValue('H'.ltrim((string)$fl), $rtot["cant3"])
    ->setCellValue('I'.ltrim((string)$fl), $rtot["pesos3"])
    ->setCellValue('J'.ltrim((string)$fl), $rtot["cant4"])
    ->setCellValue('K'.ltrim((string)$fl), $rtot["pesos4"])
    ->setCellValue('L'.ltrim((string)$fl), $rtot["cant5"])
    ->setCellValue('M'.ltrim((string)$fl), $rtot["pesos5"])
    ->setCellValue('N'.ltrim((string)$fl), $rtot["cant6"])
    ->setCellValue('O'.ltrim((string)$fl), $rtot["pesos6"])
    ->setCellValue('P'.ltrim((string)$fl), $rtot["cant7"])
    ->setCellValue('Q'.ltrim((string)$fl), $rtot["pesos7"])
    ;

$fl++;
$fl++; 
$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A'.ltrim((string)$fl),"Renglon")
    ->setCellValue('B'.ltrim((string)$fl),"Empresa") 
    ->setCellValue('C'.ltrim((string)$fl), "SG");
$fl++; 

while($r=mysqli_fetch_assoc($rsg)){
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.ltrim((string)$fl),$r["tipo_movil"]." ".$r["nombre"])
    ->setCellValue('B'.ltrim((string)$fl),$r["deno"]) 
    ->setCellValue('C'.ltrim((string)$fl), $r["cant"]);
    $fl++;
};
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('B'.ltrim((string)$fl),$rsgt["nombre"])
    ->setCellValue('C'.ltrim((string)$fl), $rsgt["cant"]);

$fl++;


$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Emitido ")
            ->setCellValue('B'.ltrim((string)$fl), ffec(un_campo("select concat(curdate(),' ',curtime()) from dual")));

$cnt=0;
for  ($col = "A"; $col <= "Q"; $col++) { 
    $cnt++;
    ajusta($col);
    if($cnt>25) {break;};
};

$titulo="Viajes-dispositivo";
$spreadsheet->setActiveSheetIndex(0)->setTitle($titulo);
$spreadsheet->setActiveSheetIndex(0);
$filename = $titulo.'.xlsx';
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
           