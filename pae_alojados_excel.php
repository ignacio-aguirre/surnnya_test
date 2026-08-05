<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$fecha=$_GET["fecha"];

$spreadsheet = new Spreadsheet();

$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1',utf8_encode('NNYA Alojados con 13 o + Años'));

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Apellido y Nombre')
            ->setCellValue('B2', 'RIB')
            ->setCellValue('C2', 'Edad '.$fecha)
            ->setCellValue('D2', 'Dispositivo de Alojamiento')
            ->setCellValue('E2', 'Estrategia de Egreso')
            ->setCellValue('F2', 'Estado en PAE')
   ;

   $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:F2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

    $sql="select nombre, sujetos.legajo,concat(apellidos,' , ', nombres) as apyn, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as edad_calc,es_egreso, rib_anio,rib_numero,rib_reparticion  
    from hogares_admision left join dispositivos on dispositivos.id=admi_hogar 
    left join sujetos on admi_legajo=sujetos.legajo 
    where admi_alta<=".fsql($fecha)." and (admi_baja is null or admi_baja>".fsql($fecha).") and edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,".fsql($fecha).")>=13 order by apellidos,nombres ";
    $reg = registros($sql);
    $nnya=0;
    $incluidos=0;
    $fl=2;
    while ($r = mysqli_fetch_assoc($reg)) {
      $nnya=$nnya+1;
      $lega=$r['legajo'];
      $estrategia=un_campo("select deno from sujetos_estrategias left join tablas on tablas.tipo='EE' and tablas.valo=estrategia where legajo=".$lega." order by fecha desc limit 1");
      $inclusion=un_campo("select id from pae_nomina where legajo=".$lega);
      if(!$inclusion>"0"){$incluido="No incluido en PAE";}
      else{$incluido=un_campo("select etapa from pae_nomina_estados where fecha<=".fsql($fecha)." and inclusion=".$inclusion." order by fecha desc limit 1");};
      if($incluido=="1") {$incluido="Alta - Etapa 1";$incluidos=$incluidos+1;};
      if($incluido=="2") {$incluido="Alta - Etapa 2";$incluidos=$incluidos+1;};
      if($incluido=="3"||$incluido=="4") {$incluido="Baja";$incluidos=$incluidos+1;};
      if($incluido=="") {$incluido="No incluido en PAE (ver)";};
      $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), utf8_encode(utf8_decode($r["apyn"])))
 	    ->setCellValue('B'.ltrim((string)$fl), rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))	
	    ->setCellValue('C'.ltrim((string)$fl), $r["edad_calc"])	
 	    ->setCellValue('D'.ltrim((string)$fl), $r["nombre"])	
 	    ->setCellValue('E'.ltrim((string)$fl), $estrategia)
 	    ->setCellValue('F'.ltrim((string)$fl), $incluido)	
 	    ;	
  };
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.ltrim((string)$fl),utf8_encode("Total Alojados 13 o + años"))
	->setCellValue('B'.ltrim((string)$fl),$nnya);
$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.ltrim((string)$fl),"Total Incluidxs en PAE")
	->setCellValue('B'.ltrim((string)$fl),$incluidos);
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),utf8_encode("Usuario ".$_SESSION["glusua"]));


for($col='A'; $col<= 'F'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('Alojados');
$spreadsheet->setActiveSheetIndex(0);
$filename="PAE-alojados.xlsx";
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
           