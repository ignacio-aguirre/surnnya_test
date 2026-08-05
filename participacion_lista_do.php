<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', utf8_encode('Espacios de Participación de NNYA en ').si($_GET["tipo"]==1,"hogares","dispositivos de acogimiento familiar"))
	    ->setCellValue('D1', utf8_encode('Participación en el ejercicio de la ciudadanía'))
	    ->setCellValue('I1', utf8_encode('Participación comunitaria - Actividades'))
	    ->setCellValue('O1', utf8_encode('Experiencias de participación'))
	    ->setCellValue('A2', 'Fecha')
	    ->setCellValue('B2', 'Dispositivo')
            ->setCellValue('C2', utf8_encode('Descripción'))
            ->setCellValue('D2', 'Total')
            ->setCellValue('E2', 'Consejos')
            ->setCellValue('F2', 'Proyectos')
            ->setCellValue('G2', 'E.Escucha')
            ->setCellValue('H2', 'Otros')
            ->setCellValue('I2', 'Total')
            ->setCellValue('J2', 'Deportivas')
            ->setCellValue('K2', 'Recreativas')
            ->setCellValue('L2', 'Culturales')
            ->setCellValue('M2', 'Barriales')
            ->setCellValue('N2', 'Otras')
            ->setCellValue('O2', 'Total')
            ->setCellValue('P2', 'Talleres')
            ->setCellValue('Q2', 'Salidas')
            ->setCellValue('R2', 'Programas')
            ->setCellValue('S2', 'Otras')

;
$sql="select super_fecha, nombre,part_detalle,
 espa_consejos+espa_proyectos+espa_escucha+espa_otros as espa_tot,
 espa_consejos as espa_con,
 espa_proyectos as espa_pro,
 espa_escucha as espa_esc,
 espa_otros as espa_otr,
 part_deportivas+part_recreativas+part_culturales+part_barriales+part_otras as part_tot,
 part_deportivas as part_dep,
 part_recreativas as part_rec,
 part_culturales as part_cul,
 part_barriales as part_bar,
 part_otras as part_otr,
 expe_talleres+expe_salidas+expe_programas+expe_otras as expe_tot,
 expe_talleres as expe_tal,
 expe_salidas as expe_sal,
 expe_programas as expe_pro,
 expe_otras as expe_otr 
from super_visita left join dispositivos on super_hogar=dispositivos.id
 where super_fecha between ".fsql($_GET["desde"])." and ".fsql($_GET["hasta"])." and tipo_dispositivo".si($_GET["tipo"]!=1,"<>2","=2")." order by super_fecha"; 
$reg=registros($sql);
$fl=2;
$etot=0;
$econ=0;
$epro=0;
$eesc=0;
$eotr=0;
$ptot=0;
$pdep=0;
$prec=0;
$pcul=0;
$pbar=0;
$potr=0;
$xtot=0;
$xtal=0;
$xsal=0;
$xpro=0;
$xotr=0;
$tot=0;
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["super_fecha"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('C'.ltrim((string)$fl), $r["part_detalle"])
            ->setCellValue('D'.ltrim((string)$fl), $r["espa_tot"])
            ->setCellValue('E'.ltrim((string)$fl), $r["espa_con"])
            ->setCellValue('F'.ltrim((string)$fl), $r["espa_pro"])
            ->setCellValue('G'.ltrim((string)$fl), $r["espa_esc"])
            ->setCellValue('G'.ltrim((string)$fl), $r["espa_otr"])
	    ->setCellValue('I'.ltrim((string)$fl), $r["part_tot"])
	    ->setCellValue('J'.ltrim((string)$fl), $r["part_dep"])
	    ->setCellValue('K'.ltrim((string)$fl), $r["part_rec"])
	    ->setCellValue('L'.ltrim((string)$fl), $r["part_cul"])
	    ->setCellValue('M'.ltrim((string)$fl), $r["part_bar"])
	    ->setCellValue('N'.ltrim((string)$fl), $r["part_otr"])
	    ->setCellValue('O'.ltrim((string)$fl), $r["expe_tot"])
	    ->setCellValue('P'.ltrim((string)$fl), $r["expe_tal"])
	    ->setCellValue('Q'.ltrim((string)$fl), $r["expe_sal"])
	    ->setCellValue('R'.ltrim((string)$fl), $r["expe_pro"])
	    ->setCellValue('S'.ltrim((string)$fl), $r["expe_otr"])
;

 $etot=$etot+$r["espa_tot"];
 $econ=$econ+$r["espa_con"];
 $epro=$epro+$r["espa_pro"];
 $eesc=$eesc+$r["espa_esc"];
 $eotr=$eotr+$r["espa_otr"];
 $ptot=$ptot+$r["part_tot"];
 $pdep=$pdep+$r["part_dep"];
 $prec=$prec+$r["part_rec"];
 $pcul=$pcul+$r["part_cul"];
 $pbar=$pbar+$r["part_bar"];
 $potr=$potr+$r["part_otr"];
 $xtot=$xtot+$r["expe_tot"];
 $xtal=$xtal+$r["expe_tal"];
 $xsal=$xsal+$r["expe_sal"];
 $xpro=$xpro+$r["expe_pro"];
 $xotr=$xotr+$r["expe_otr"];
 $tot=$tot+1;

};


$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "T O T A L E S")
            ->setCellValue('C'.ltrim((string)$fl), $tot)
            ->setCellValue('D'.ltrim((string)$fl), $etot)
            ->setCellValue('E'.ltrim((string)$fl), $econ)
            ->setCellValue('F'.ltrim((string)$fl), $epro)
            ->setCellValue('G'.ltrim((string)$fl), $eesc)
            ->setCellValue('H'.ltrim((string)$fl), $eotr)
	    ->setCellValue('I'.ltrim((string)$fl), $ptot)
	    ->setCellValue('J'.ltrim((string)$fl), $pdep)
	    ->setCellValue('K'.ltrim((string)$fl), $prec)
	    ->setCellValue('L'.ltrim((string)$fl), $pcul)
	    ->setCellValue('M'.ltrim((string)$fl), $pbar)
	    ->setCellValue('N'.ltrim((string)$fl), $potr)
	    ->setCellValue('O'.ltrim((string)$fl), $xtot)
	    ->setCellValue('P'.ltrim((string)$fl), $xtal)
	    ->setCellValue('Q'.ltrim((string)$fl), $xsal)
	    ->setCellValue('R'.ltrim((string)$fl), $xpro)
	    ->setCellValue('S'.ltrim((string)$fl), $xotr)
;

$auf=ltrim((string)($fl-1));
$spreadsheet->setActiveSheetIndex(0)->getStyle("A1:C".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$spreadsheet->setActiveSheetIndex(0)->getStyle("D1:H".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('C4F7B3');

$spreadsheet->setActiveSheetIndex(0)->getStyle("I1:N".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('F5CA42');

$spreadsheet->setActiveSheetIndex(0)->getStyle("O1:S".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('F7F76C');

$spreadsheet->setActiveSheetIndex(0)->getStyle("A".ltrim((string)$fl).":S".ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


for($col='B'; $col<= 'C'; $col++){
	ajusta($col);
};

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Desde ".$_GET["desde"]." / Hasta ".$_GET["hasta"]);
$fl=$fl+2;
 $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);


$spreadsheet->getActiveSheet()->setTitle('ParticipacionNNYA');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'EsParticipacion-lista.xlsx';

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