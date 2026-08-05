<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();

$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nombre')
            ->setCellValue('B1', 'ONG')
            ->setCellValue('C1', 'Tipo de Dispositivo')
            ->setCellValue('D1', 'Modalidad')
            ->setCellValue('E1', utf8_encode('Poblacion:Género'))
            ->setCellValue('F1', utf8_encode('Poblacion:Edades'))
            ->setCellValue('G1', utf8_encode('Poblacion:Especificación'))
            ->setCellValue('H1', 'Plazas')
            ->setCellValue('I1', 'Domicilio')
            ->setCellValue('J1', 'Localidad')
            ->setCellValue('K1', 'Barrio')
            ->setCellValue('L1', 'Comuna')
            ->setCellValue('M1', 'Telefono')
            ->setCellValue('N1', 'Email')
            ->setCellValue('O1', 'Referente')
            ->setCellValue('P1', utf8_encode('Unidad Técnica'))
            ->setCellValue('Q1', 'CDNNYA')
            ->setCellValue('R1', 'Conveniado')
	    ->setCellValue('S1', utf8_encode('Área Gubernamental'))
	    ->setCellValue('T1', utf8_encode('Dirección Operativa'))
	    ->setCellValue('U1', utf8_encode('Empresa Móviles'))

;            
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:U1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$sql="select  dispositivos.*, hogares_ong.nombre as dong, hmod.deno as dmodalidad, utec.deno as ut, tdis.deno as td, diop.deno as do, agub.deno as ag
, etra.deno as et from dispositivos 
left join hogares_ong on ong=hogares_ong.id  
left join tablas hmod on hmod.tipo='HOMOD' and hmod.valo=modalidad
left join tablas utec on utec.tipo='SUPUT' and utec.valo=unidad_tecnica
left join tablas diop on diop.tipo='DIOP' and diop.valo=direccion_operativa
left join tablas tdis on tdis.tipo='DITIP' and tdis.valo=tipo_dispositivo
left join tablas agub on agub.tipo='AGUB' and agub.valo=area_gubernamental 
left join tablas etra on etra.tipo='ETRA' and etra.valo=transporte 
where dispositivos.baja is null and dispositivos.baja_sistema is null and tipo_dispositivo in (1,2,11,12) and nomina_hogares=1 order by td,ut,nombre";
$conn=registros($sql);
$fl=1;
while ($r = mysqli_fetch_assoc($conn)) {
 $fl=$fl+1;
 $ong=$r["dong"];
 $hoga=$r["nombre"];
 $tipo=$r["td"];
 $moda=$r["dmodalidad"];
 $pobl=$r["poblacion"];
 $gene=si($r["genero_poblacion"]==1,"Femenino",si($r["genero_poblacion"]==2,"Masculino","Ambos"));
 $domi=$r["domicilio"]." ".$r["piso_departamento"];
 $loca=$r["localidad"];
 $barr=$r["barrio"];
 $comu=$r["comuna"]; 
 $tele=$r["telefonos"];
 $mail=strtolower($r["Hogares_Mail"]);
 $resp=$r["referente"];
 $vaca=$r["plazas"];
 $utec=$r["ut"];
 $prop=si($r["conveniado"]==1,"No","Si");
 $conv=si($r["conveniado"]==1,"Si","No");
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $hoga)
            ->setCellValue('B'.ltrim((string)$fl), $ong)
            ->setCellValue('C'.ltrim((string)$fl), $tipo)
            ->setCellValue('D'.ltrim((string)$fl), $moda)
            ->setCellValue('E'.ltrim((string)$fl), $gene)
	    ->setCellValue('F'.ltrim((string)$fl), "de ".$r["etaria_desde"]." a ".$r["etaria_hasta"])
	    ->setCellValue('G'.ltrim((string)$fl), $pobl)
            ->setCellValue('H'.ltrim((string)$fl), $vaca)
            ->setCellValue('I'.ltrim((string)$fl), $domi)
            ->setCellValue('J'.ltrim((string)$fl), $loca)
            ->setCellValue('K'.ltrim((string)$fl), $barr)
            ->setCellValue('L'.ltrim((string)$fl), $comu)
            ->setCellValue('M'.ltrim((string)$fl), $tele)
            ->setCellValue('N'.ltrim((string)$fl), $mail)
            ->setCellValue('O'.ltrim((string)$fl), $resp)
            ->setCellValue('P'.ltrim((string)$fl), $utec)
            ->setCellValue('Q'.ltrim((string)$fl), $prop)
            ->setCellValue('R'.ltrim((string)$fl), $conv)
            ->setCellValue('S'.ltrim((string)$fl), $r["ag"])
            ->setCellValue('T'.ltrim((string)$fl), $r["do"])
            ->setCellValue('U'.ltrim((string)$fl), $r["et"])

   ;
}
for($col='A'; $col<= 'U'; $col++){
	ajusta($col);
};
 $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
;
$spreadsheet->getActiveSheet()->setTitle('DispositivosCuidado');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Dispo-Cuidado.xlsx';

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



           