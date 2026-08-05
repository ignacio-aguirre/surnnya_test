<?php
session_start();
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("funciones.php");
if($_SESSION["perfil_moviles"]!="1") {Redirect($_SESSION['menu']);};
if($_SESSION["hogar"]>"0"){
    $cond=" dispositivo=".$_SESSION["hogar"];
}
else{
    $cond=" sector=".$_SESSION["sector"];
};
$fini=str_replace("-","",$_GET["fini"]);
$ffin=str_replace("-","",$_GET["ffin"]);

$spreadsheet = new Spreadsheet();

$spreadsheet->setActiveSheetIndex(0)
            
            ->setCellValue('A1', 'Solicitante')
            ->setCellValue('B1', 'Fecha')
            ->setCellValue('C1', 'Hora')
            ->setCellValue('D1', 'Tipo movil')
            ->setCellValue('E1', 'Partida')
            ->setCellValue('F1', 'Destino 1')
            ->setCellValue('G1', 'Destino 2')
            ->setCellValue('H1', 'Destino 3')
            ->setCellValue('I1', 'Destino 4')
            ->setCellValue('J1', 'NNYA')
	       ->setCellValue('K1', 'Adultos')
	       ->setCellValue('L1', 'Motivo recurso')
	       ->setCellValue('M1', 'Comentarios')
	       ->setCellValue('N1', 'Estado')
	       ->setCellValue('O1', 'Observaciones administrador')
	       ->setCellValue('P1', 'Pas alojados')
	       ->setCellValue('Q1', 'Pas adultos');
$spreadsheet->getActiveSheet()->getStyle('A1:Q1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select movil_viajes.*, movil_renglones.nombre_info as tipo, case when dispositivo>0 then dispositivos.nombre else sectores.denominacion end as solicitante, mvmt.deno as motivo from movil_viajes left join dispositivos on dispositivo=dispositivos.id left join sectores on sector=sectores.id  
left join movil_renglones on movil_renglones.id=tipo_movil 
left join tablas mvmt on mvmt.tipo='MVMT' and mvmt.valo=motivo_recurso where fecha between ".$fini." and ".$ffin." and ".$cond." order by solicitante,fecha, hora";
$reg=registros($sql);
$fl=1;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["solicitante"])
            ->setCellValue('B'.ltrim((string)$fl), ffec($r["fecha"]))
            ->setCellValue('C'.ltrim((string)$fl), substr($r["hora"],0,5))
            ->setCellValue('D'.ltrim((string)$fl), $r["tipo"])
            ->setCellValue('E'.ltrim((string)$fl), $r["partida"])
            ->setCellValue('F'.ltrim((string)$fl), $r["destino_1"])
            ->setCellValue('G'.ltrim((string)$fl), $r["destino_2"])
            ->setCellValue('H'.ltrim((string)$fl), $r["destino_3"])
            ->setCellValue('I'.ltrim((string)$fl), $r["destino_4"])
            ->setCellValue('J'.ltrim((string)$fl), $r["pasajeros_alojados"])
            ->setCellValue('K'.ltrim((string)$fl), $r["pasajeros_acompaniantes"])
            ->setCellValue('L'.ltrim((string)$fl), $r["motivo"])
            ->setCellValue('M'.ltrim((string)$fl), $r["comentarios"])
            ->setCellValue('N'.ltrim((string)$fl), $r["estado"])
            ->setCellValue('O'.ltrim((string)$fl), $r["observaciones"])

;
 $pas=registros("select pas_nombre from movil_pasajeros where viaje=".$r["id"]." and tipo_pasajero=1 order by pas_nombre");
 $pal="";
 while($p=mysqli_fetch_assoc($pas)){
    $pal=$pal.si($pal=="","","-").$p["pas_nombre"];
 };
 $pas=registros("select pas_nombre,celular from movil_pasajeros where viaje=".$r["id"]." and tipo_pasajero=2 order by pas_nombre");
 $pac="";
 while($p=mysqli_fetch_assoc($pas)){
    $pac=$pac.si($pac=="","","-").$p["pas_nombre"]." cel:".$p["celular"];
 };
 $spreadsheet->setActiveSheetIndex(0)
         ->setCellValue('P'.ltrim((string)$fl), $pal)
         ->setCellValue('Q'.ltrim((string)$fl), $pac);
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
           