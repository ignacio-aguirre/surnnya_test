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
	    ->setCellValue('C1', utf8_encode('Participación en el ejercicio de la ciudadanía'))
	    ->setCellValue('H1', utf8_encode('Participación comunitaria - Actividades'))
	    ->setCellValue('N1', utf8_encode('Experiencias de participación'))
	    ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'Visitas')
            ->setCellValue('C2', 'Total')
            ->setCellValue('D2', 'Consejos')
            ->setCellValue('E2', 'Proyectos')
            ->setCellValue('F2', 'E.Escucha')
            ->setCellValue('G2', 'Otros')
            ->setCellValue('H2', 'Total')
            ->setCellValue('I2', 'Deportivas')
            ->setCellValue('J2', 'Recreativas')
            ->setCellValue('K2', 'Culturales')
            ->setCellValue('L2', 'Barriales')
            ->setCellValue('M2', 'Otras')
            ->setCellValue('N2', 'Total')
            ->setCellValue('O2', 'Talleres')
            ->setCellValue('P2', 'Salidas')
            ->setCellValue('Q2', 'Programas')
            ->setCellValue('R2', 'Otras')

;
$sql="select nombre,
 sum(espa_consejos+espa_proyectos+espa_escucha+espa_otros) as espa_tot,
 sum(espa_consejos) as espa_con,
 sum(espa_proyectos) as espa_pro,
 sum(espa_escucha) as espa_esc,
 sum(espa_otros) as espa_otr,
 sum(part_deportivas+part_recreativas+part_culturales+part_barriales+part_otras) as part_tot,
 sum(part_deportivas) as part_dep,
 sum(part_recreativas) as part_rec,
 sum(part_culturales) as part_cul,
 sum(part_barriales) as part_bar,
 sum(part_otras) as part_otr,
 sum(expe_talleres+expe_salidas+expe_programas+expe_otras) as expe_tot,
 sum(expe_talleres) as expe_tal,
 sum(expe_salidas) as expe_sal,
 sum(expe_programas) as expe_pro,
 sum(expe_otras) as expe_otr,
 count(*) as tot 
from super_visita left join dispositivos on super_hogar=dispositivos.id
 where super_fecha between ".fsql($_GET["desde"])." and ".fsql($_GET["hasta"])." and tipo_dispositivo".si($_GET["tipo"]==1,"<>1","=1")." group by nombre order by nombre"; 
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
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["tot"])
            ->setCellValue('C'.ltrim((string)$fl), $r["espa_tot"])
            ->setCellValue('D'.ltrim((string)$fl), $r["espa_con"])
            ->setCellValue('E'.ltrim((string)$fl), $r["espa_pro"])
            ->setCellValue('F'.ltrim((string)$fl), $r["espa_esc"])
            ->setCellValue('G'.ltrim((string)$fl), $r["espa_otr"])
	    ->setCellValue('H'.ltrim((string)$fl), $r["part_tot"])
	    ->setCellValue('I'.ltrim((string)$fl), $r["part_dep"])
	    ->setCellValue('J'.ltrim((string)$fl), $r["part_rec"])
	    ->setCellValue('K'.ltrim((string)$fl), $r["part_cul"])
	    ->setCellValue('L'.ltrim((string)$fl), $r["part_bar"])
	    ->setCellValue('M'.ltrim((string)$fl), $r["part_otr"])
	    ->setCellValue('N'.ltrim((string)$fl), $r["expe_tot"])
	    ->setCellValue('O'.ltrim((string)$fl), $r["expe_tal"])
	    ->setCellValue('P'.ltrim((string)$fl), $r["expe_sal"])
	    ->setCellValue('Q'.ltrim((string)$fl), $r["expe_pro"])
	    ->setCellValue('R'.ltrim((string)$fl), $r["expe_otr"])
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
 $tot=$tot+$r["tot"];

};


$fl=$fl+1;
  $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "T O T A L E S")
            ->setCellValue('B'.ltrim((string)$fl), $tot)
            ->setCellValue('C'.ltrim((string)$fl), $etot)
            ->setCellValue('D'.ltrim((string)$fl), $econ)
            ->setCellValue('E'.ltrim((string)$fl), $epro)
            ->setCellValue('F'.ltrim((string)$fl), $eesc)
            ->setCellValue('G'.ltrim((string)$fl), $eotr)
	    ->setCellValue('H'.ltrim((string)$fl), $ptot)
	    ->setCellValue('I'.ltrim((string)$fl), $pdep)
	    ->setCellValue('J'.ltrim((string)$fl), $prec)
	    ->setCellValue('K'.ltrim((string)$fl), $pcul)
	    ->setCellValue('L'.ltrim((string)$fl), $pbar)
	    ->setCellValue('M'.ltrim((string)$fl), $potr)
	    ->setCellValue('N'.ltrim((string)$fl), $xtot)
	    ->setCellValue('O'.ltrim((string)$fl), $xtal)
	    ->setCellValue('P'.ltrim((string)$fl), $xsal)
	    ->setCellValue('Q'.ltrim((string)$fl), $xpro)
	    ->setCellValue('R'.ltrim((string)$fl), $xotr)
;
$auf=ltrim((string)($fl-1));
$spreadsheet->setActiveSheetIndex(0)->getStyle("A1:B".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$spreadsheet->setActiveSheetIndex(0)->getStyle("C1:G".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('C4F7B3');

$spreadsheet->setActiveSheetIndex(0)->getStyle("H1:M".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('F5CA42');


$spreadsheet->setActiveSheetIndex(0)->getStyle("N1:R".$auf)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('F7F76C');


$spreadsheet->setActiveSheetIndex(0)->getStyle("A".ltrim((string)$fl).":H".ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

for($col='A'; $col<= 'B'; $col++){
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
$filename = 'Espacios-participacion.xlsx';

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