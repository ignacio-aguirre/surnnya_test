<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$tipo=nget("tipo");
$titulo="DISPOSITIVOS";
if($tipo>"0"){$titulo=$titulo." ".un_campo("select deno from tablas where tipo='DITIP' and valo=".$tipo);};
$spreadsheet = new Spreadsheet();

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', utf8_encode($titulo))
            ->setCellValue('A2', 'Nombre')
            ->setCellValue('B2', 'ONG')
            ->setCellValue('C2', 'Legajo')
            ->setCellValue('D2', 'Tipo de Dispositivo')
            ->setCellValue('E2', 'Modalidad')
            ->setCellValue('F2', utf8_encode('Poblacion:Género'))
            ->setCellValue('G2', utf8_encode('Poblacion:Edades'))
            ->setCellValue('H2', utf8_encode('Poblacion:Especificación'))
            ->setCellValue('I2', 'Plazas')
            ->setCellValue('J2', utf8_encode('Unidad Técnica Supervisión'))
            ->setCellValue('K2', utf8_encode('Frecuencia Monitoreo'))
            ->setCellValue('L2', 'Domicilio')
            ->setCellValue('M2', 'Localidad')
            ->setCellValue('N2', 'Barrio')
            ->setCellValue('O2', 'Comuna')
            ->setCellValue('P2', 'Telefono')
            ->setCellValue('Q2', 'Email')
            ->setCellValue('R2', 'Referente')
            ->setCellValue('S2', 'Celular Referente')
            ->setCellValue('T2', 'Estado')
            ->setCellValue('U2', utf8_encode('Nómina CDNNYA'))
	    ->setCellValue('V2', 'Responsable Monitoreo')
	    ->setCellValue('W2', utf8_encode('Trámite Eximición Habilitación'))
	    ->setCellValue('X2', utf8_encode('Área Gubernamental'));            
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:X2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');
$sql="select  dispositivos.*, hogares_ong.nombre as dong, legajo, hmod.deno as dmodalidad, utec.deno as ut, tdis.deno as td, agub.deno as ag,  usuarios.apellido as uape, usuarios.nombre as unom 
from dispositivos 
left join hogares_ong on ong=hogares_ong.id  
left join tablas hmod on hmod.tipo='HOMOD' and modalidad=hmod.valo 
left join tablas utec on utec.tipo='SUPUT' and utec.valo=unidad_tecnica
left join tablas tdis on tdis.tipo='DITIP' and tdis.valo=tipo_dispositivo
left join tablas agub on agub.tipo='AGUB' and agub.valo=area_gubernamental 
left join usuarios on usuarios.id=usuario_monitoreo 
where dispositivos.baja_sistema is null ";
if($tipo>"0"){$sql=$sql." and tipo_dispositivo=".$tipo;};
$sql=$sql." order by nombre";
$conn=registros($sql);
$fl=2;
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
 $frec=frecuencia($r["frecuencia"]);
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $hoga)
            ->setCellValue('B'.ltrim((string)$fl), $ong)
	    ->setCellValue('C'.ltrim((string)$fl), $r["legajo"])
	    ->setCellValue('D'.ltrim((string)$fl), $tipo)
            ->setCellValue('E'.ltrim((string)$fl), $moda)
            ->setCellValue('F'.ltrim((string)$fl), $gene)
	    ->setCellValue('G'.ltrim((string)$fl), "de ".$r["etaria_desde"]." a ".$r["etaria_hasta"])
	    ->setCellValue('H'.ltrim((string)$fl), $pobl)
            ->setCellValue('I'.ltrim((string)$fl), $vaca)
            ->setCellValue('J'.ltrim((string)$fl), $utec)
            ->setCellValue('K'.ltrim((string)$fl), $frec)
            ->setCellValue('L'.ltrim((string)$fl), $domi)
            ->setCellValue('M'.ltrim((string)$fl), $loca)
            ->setCellValue('N'.ltrim((string)$fl), $barr)
            ->setCellValue('O'.ltrim((string)$fl), $comu)
            ->setCellValue('P'.ltrim((string)$fl), $tele)
            ->setCellValue('Q'.ltrim((string)$fl), $mail)
            ->setCellValue('R'.ltrim((string)$fl), $resp)
            ->setCellValue('S'.ltrim((string)$fl), $r["celular_referente"])
            ->setCellValue('T'.ltrim((string)$fl), si(ffec($r["baja"])=="","Alta","Baja"))
            ->setCellValue('U'.ltrim((string)$fl), si($r["nomina_hogares"]=="1","SI","NO"))
            ->setCellValue('V'.ltrim((string)$fl), si($r["uape"]=="","",$r["uape"].", ".$r["unom"]))
            ->setCellValue('W'.ltrim((string)$fl), $r["tramite_eximicion"])
            ->setCellValue('X'.ltrim((string)$fl), $r["ag"])

   ;
}
for($col='A'; $col<= 'X'; $col++){
	ajusta($col);
};
 $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
;
$spreadsheet->getActiveSheet()->setTitle('Dispositivos');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Dispositivos.xlsx';

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
function frecuencia($f){
 if($f==3) {return "Trimestral";};
 if($f==4) {return "Cuatrimestral";};
 if($f==6) {return "Semestral";};
 if($f==12) {return "Anual";};

 return ""; 
}

?>



           