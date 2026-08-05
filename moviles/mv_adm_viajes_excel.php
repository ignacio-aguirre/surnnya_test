<?php
session_start();
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("funciones.php");
if($_SESSION["perfil_moviles"]!="2") {Redirect("salir");};
if($_SESSION["supervisa"]=="B13"){
    $cond=" movil_viajes.bandeja in(1,3,6,7) ";
}
else{
    $cond=" movil_viajes.bandeja in(2,4,5) ";
};
$fini=str_replace("-","",$_GET["fini"]);
$ffin=str_replace("-","",$_GET["ffin"]);

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()
        ->setCreator("SURNNYA");

$spreadsheet->setActiveSheetIndex(0)
            
            ->setCellValue('A1', 'Solicitante')
            ->setCellValue('B1', 'Fecha')
            ->setCellValue('C1', 'Hora')
            ->setCellValue('D1', 'Tipo movil')
            ->setCellValue('E1', 'Empresa')
            ->setCellValue('F1', 'Partida')
            ->setCellValue('G1', 'Destino 1')
            ->setCellValue('H1', 'Destino 2')
            ->setCellValue('I1', 'Destino 3')
            ->setCellValue('J1', 'Destino 4')
            ->setCellValue('K1', 'NNYA')
	       ->setCellValue('L1', 'Adultos')
	       ->setCellValue('M1', 'Motivo recurso')
	       ->setCellValue('N1', 'Comentarios')
	       ->setCellValue('O1', 'Estado')
           ->setCellValue('P1', 'Bandeja')
	       ->setCellValue('Q1', 'Observaciones administrador');
$spreadsheet->getActiveSheet()->getStyle('A1:Q1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select movil_viajes.*, movil_renglones.nombre_info as tipo, case when dispositivo>0 then dispositivos.nombre else sectores.denominacion end as solicitante, mvmt.deno as motivo,etra.deno as empre  from movil_viajes left join dispositivos on dispositivo=dispositivos.id left join sectores on sector=sectores.id  left join movil_renglones on tipo_movil=movil_renglones.id  
left join tablas mvmt on mvmt.tipo='MVMT' and mvmt.valo=motivo_recurso 
left join tablas etra on etra.tipo='ETRA' and etra.valo=empresa 

where fecha between ".$fini." and ".$ffin." and ".$cond." order by solicitante,fecha, hora";

$reg=registros($sql);
$fl=1;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["solicitante"])
            ->setCellValue('B'.ltrim((string)$fl), ffec($r["fecha"]))
            ->setCellValue('C'.ltrim((string)$fl), substr($r["hora"],0,5))
            ->setCellValue('D'.ltrim((string)$fl), $r["tipo"])
            ->setCellValue('E'.ltrim((string)$fl), $r["empre"])
            ->setCellValue('F'.ltrim((string)$fl), $r["partida"])
            ->setCellValue('G'.ltrim((string)$fl), $r["destino_1"])
            ->setCellValue('H'.ltrim((string)$fl), $r["destino_2"])
            ->setCellValue('I'.ltrim((string)$fl), $r["destino_3"])
            ->setCellValue('J'.ltrim((string)$fl), $r["destino_4"])
            ->setCellValue('K'.ltrim((string)$fl), $r["pasajeros_alojados"]);
        $pas=registros("select pas_nombre ,celular from movil_pasajeros where viaje=".$r["id"]." and tipo_pasajero=2 order by  pas_nombre");
 $pac="";
 while($p=mysqli_fetch_assoc($pas)){
    $pac=$pac.si($pac=="","","-").$p["pas_nombre"]." cel:".$p["celular"];
 };
 $spreadsheet->setActiveSheetIndex(0)
         ->setCellValue('L'.ltrim((string)$fl), $pac)
         ->setCellValue('M'.ltrim((string)$fl), $r["motivo"])
         ->setCellValue('N'.ltrim((string)$fl), $r["comentarios"])
         ->setCellValue('O'.ltrim((string)$fl), $r["estado"])
         ->setCellValue('P'.ltrim((string)$fl), $r["estado"])
            ->setCellValue('Q'.ltrim((string)$fl), $r["observaciones"])

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
$fl++;
 $spreadsheet->setActiveSheetIndex(0)
     ->setCellValue('A'.ltrim((string)$fl), "Desde/hasta")
     ->setCellValue('B'.ltrim((string)$fl), ffec($_GET["fini"]))
     ->setCellValue('C'.ltrim((string)$fl), ffec($_GET["ffin"]))
         ;



 
for($col='A'; $col<= 'Q'; $col++){
    ajusta($col);
};


$spreadsheet->getActiveSheet()->setTitle('Viajes');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Viajes.xlsx';
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
           