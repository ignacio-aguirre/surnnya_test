<?php
error_reporting(E_STRICT);
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
include("funciones.php");
$titulo="Viajes";
if(isset($_GET["fini"])){
  $fini=$_GET["fini"];
  $ffin=$_GET["ffin"];
      $reg=registros("select movil_viajes.*, case when dispositivo=0 then sectores.denominacion else dispositivos.nombre end as solicitante, mvmt.deno as motivo, nemp.deno as nempre,movil_renglones.nombre as renglon from movil_viajes 
    left join tablas mvmt on mvmt.tipo='MVMT' and mvmt.valo=motivo_recurso 
    left join tablas nemp on nemp.tipo='ETRA' and nemp.valo=movil_viajes.empresa
    left join movil_renglones on movil_renglones.id=tipo_movil 
    left join dispositivos on movil_viajes.dispositivo=dispositivos.id 
    left join sectores on movil_viajes.sector=sectores.id 
    where movil_viajes.fecha between ".$fini." and ".$ffin." and movil_viajes.bandeja =7     order by nempre, fecha, hora,solicitante");
  $fnn=1;
};

$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NRO')
            ->setCellValue('B1', 'Empresa')
            ->setCellValue('C1', 'Renglón')
            ->setCellValue('D1', 'Especificación renglón')
            ->setCellValue('E1', 'Tipo de transporte')
            ->setCellValue('F1', 'Solicitante')
            ->setCellValue('G1', 'Fecha solicitud')
            ->setCellValue('H1', 'Fecha de viaje')
            ->setCellValue('I1', 'Hora')
            ->setCellValue('J1', 'Pax NNYA')
            ->setCellValue('K1', 'Pax Adul.')
            ->setCellValue('L1', 'Punto partida')
            ->setCellValue('M1', 'Destino')
            ->setCellValue('N1', 'Motivo')
            ->setCellValue('O1', 'Valor pliego')
            ->setCellValue('P1', 'Cantidad 10 KM (R 7)')
            ->setCellValue('Q1', 'Hora adicional (remise)')
            ->setCellValue('R1', 'Bloques 10 Minutos s/hora (remise)')
            ->setCellValue('S1', 'Cancelado(Sí/No)')
            ->setCellValue('T1', 'Valor viaje')
            ->setCellValue('U1', 'SG');
$spreadsheet->getActiveSheet()->getStyle('A1:U1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');



$fl=1;
$fnn=1;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 
 $cosa=valoriza($r["id"]);
 $destinos=si($r["destino_2"]!="","1.","").$r["destino_1"];
 if($r["destino_2"]!=""){$destinos=$destinos." 2.".$r["destino_2"];};
 if($r["destino_3"]!=""){$destinos=$destinos." 3.".$r["destino_3"];};
 if($r["destino_4"]!=""){$destinos=$destinos." 4.".$r["destino_4"];};
 
 $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.ltrim((string)$fl),$r["id"])
    ->setCellValue('B'.ltrim((string)$fl),$r["nempre"])
    ->setCellValue('C'.ltrim((string)$fl), $r["tipo_movil"]) 
    ->setCellValue('D'.ltrim((string)$fl), $r["renglon"])
    ->setCellValue('E'.ltrim((string)$fl), si($r["tipo_tipo"]=="1","REMISE","MINIBUS/COMBI"))
    ->setCellValue('F'.ltrim((string)$fl), $r["solicitante"])
    ->setCellValue('G'.ltrim((string)$fl), ffec($r["f_solicitud"]))
    ->setCellValue('H'.ltrim((string)$fl), ffec($r["fecha"]))
    ->setCellValue('I'.ltrim((string)$fl), substr($r["hora"],0,5))
    ->setCellValue('J'.ltrim((string)$fl), $r["pasajeros_alojados"])
    ->setCellValue('K'.ltrim((string)$fl), $r["pasajeros_acompaniantes"])
    ->setCellValue('L'.ltrim((string)$fl), $r["partida"])
    ->setCellValue('M'.ltrim((string)$fl), $destinos)
    ->setCellValue('N'.ltrim((string)$fl),$r["motivo"])
    ->setCellValue('O'.ltrim((string)$fl),$r["valor_base"])
    ->setCellValue('P'.ltrim((string)$fl),$r["b10_km"])
    ->setCellValue('Q'.ltrim((string)$fl),$r["hora_adicional"])
    ->setCellValue('R'.ltrim((string)$fl),$r["minutos_adicionales"])
    ->setCellValue('S'.ltrim((string)$fl),si($r["cancelado"]=="1","SI",si($r["estado"]=="CAN","SUSPENDIDO","NO")))
    ->setCellValue('T'.ltrim((string)$fl),$r["valor_calculado"])
    ->setCellValue('U'.ltrim((string)$fl),$r["sg"])
 
;
 
 
};

$fl++;


$fl++;

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Emitido ")
            ->setCellValue('B'.ltrim((string)$fl), ffec(un_campo("select concat(curdate(),' ',curtime()) from dual")));

$fl++;   
if(isset($_GET["fini"])) {
    $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Desde ")
            ->setCellValue('B'.ltrim((string)$fl), sqlf($fini));
         $fl++;   
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Hasta ")
            ->setCellValue('B'.ltrim((string)$fl), sqlf($ffin));
}


$cnt=0;
for  ($col = "A"; $col <= "W"; $col++) { 
    $cnt++;
    if($col!="P" && $col!="R"){
	ajusta($col);
    };
    if($cnt>26) {break;};
};

$spreadsheet->setActiveSheetIndex(0);
$spreadsheet->getActiveSheet()->setTitle($titulo);

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
           