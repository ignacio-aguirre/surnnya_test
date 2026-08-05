<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$departamento=nget("departamento");
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'REGISTRO DE ONG')
            ->setCellValue('A2', 'Legajo')
            ->setCellValue('B2', utf8_encode('Razón Social'))
            ->setCellValue('C2', utf8_encode('Pers.Jurídica'))
            ->setCellValue('D2', utf8_encode('Forma Jurídica'))
            ->setCellValue('E2', 'CUIT')
            ->setCellValue('F2', 'Referente Institucional')
            ->setCellValue('G2', 'Celular Ref.Institucional')
            ->setCellValue('H2', 'Domicilio Legal')
            ->setCellValue('I2', 'Localidad')
            ->setCellValue('J2', 'Barrio')
            ->setCellValue('K2', 'C.P.')
            ->setCellValue('L2', 'Comuna')
            ->setCellValue('M2', utf8_encode('Teléfonos'))
            ->setCellValue('N2', 'Email')
            ->setCellValue('O2', utf8_encode('Atención Directa'))
            ->setCellValue('P2', utf8_encode('Necesidades Especiales'))
            ->setCellValue('Q2', utf8_encode('Promoción'))
            ->setCellValue('R2', utf8_encode('Académicas/Investigación'))
            ->setCellValue('S2', utf8_encode('Género'))
            ->setCellValue('T2', utf8_encode('Área Plenario'))
            ->setCellValue('U2', 'Conveniada')
            ->setCellValue('V2', utf8_encode('Repartición Convenio'))
            ->setCellValue('W2', 'Estado')
            ->setCellValue('X2', 'Departamento')
            ->setCellValue('Y2', utf8_encode('Frecuencia Fiscalización'))
            ->setCellValue('Z2', 'Fecha Alta')
            ->setCellValue('AA2', 'Resol.Alta')
            ->setCellValue('AB2', 'Fecha Baja')
            ->setCellValue('AC2', 'Resol.Baja')
            ->setCellValue('AD2', 'Dispositivos Activos')
            ->setCellValue('AE2', 'Dispositivo 1')
            ->setCellValue('AF2', 'Dispositivo 2')
            ->setCellValue('AG2', 'Dispositivo 3')
            ->setCellValue('AH2', 'Dispositivo 4')
            ->setCellValue('AI2', 'Dispositivo 5');
            
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:AI2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select hogares_ong.*, (select count(*) from dispositivos 
where baja_sistema is null and ong=hogares_ong.id) as cantidad, barrios_caba.barrio ,formas.deno as dtipo, estados.deno as destado, areas.deno as plenario from hogares_ong 
 left join tablas estados on estados.tipo='EONG' and estados.valo=estado
 left join tablas formas on formas.tipo='TENT' and formas.valo=tipo_entidad
 left join tablas areas on areas.tipo='AONG' and areas.valo=area_plenario
 left join barrios_caba on idbarrios_caba=hogares_ong.barrio ";
if($departamento!="0"){$sql=$sql." where departamento=".$departamento;};
 $sql=$sql." order by nombre";
$conn=registros($sql);
$fl=2;
while ($r = mysqli_fetch_assoc($conn)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["legajo"])
            ->setCellValue('B'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('C'.ltrim((string)$fl), $r["igj"])
            ->setCellValue('D'.ltrim((string)$fl), $r["dtipo"])
            ->setCellValue('E'.ltrim((string)$fl), $r["cuit"])
            ->setCellValue('F'.ltrim((string)$fl), $r["referente"])
            ->setCellValue('G'.ltrim((string)$fl), $r["celular_referente"])
            ->setCellValue('H'.ltrim((string)$fl), $r["domicilio_legal"]." ".$r["piso_departamento"])
            ->setCellValue('I'.ltrim((string)$fl), $r["localidad"])
            ->setCellValue('J'.ltrim((string)$fl), $r["barrio"])
            ->setCellValue('K'.ltrim((string)$fl), $r["codigo_postal"])
            ->setCellValue('L'.ltrim((string)$fl), $r["comuna"])
            ->setCellValue('M'.ltrim((string)$fl), $r["telefonos"])
            ->setCellValue('N'.ltrim((string)$fl), strtolower($r["email"]))
            ->setCellValue('O'.ltrim((string)$fl), si($r["atencion_directa"]=="1","SI","NO"))
            ->setCellValue('P'.ltrim((string)$fl), si($r["necesidades_especiales"]=="1","SI","NO"))
            ->setCellValue('Q'.ltrim((string)$fl), si($r["promocion"]=="1","SI","NO"))
            ->setCellValue('R'.ltrim((string)$fl), si($r["academicas_investigacion"]=="1","SI","NO"))
            ->setCellValue('S'.ltrim((string)$fl), si($r["genero"]=="1","SI","NO"))
            ->setCellValue('T'.ltrim((string)$fl), $r["plenario"])
            ->setCellValue('U'.ltrim((string)$fl), si($r["conveniada"]=="1","SI","NO"))
            ->setCellValue('V'.ltrim((string)$fl), $r["reparticion_convenio"])
            ->setCellValue('W'.ltrim((string)$fl), $r["destado"])
            ->setCellValue('X'.ltrim((string)$fl), utf8_encode(si($r["departamento"]=="1","Monitoreo","Fiscalización")))
            ->setCellValue('Y'.ltrim((string)$fl), ffis($r["frecuencia_fiscalizacion"]))
            ->setCellValue('Z'.ltrim((string)$fl), ffec($r["fecha_alta"]))
            ->setCellValue('AA'.ltrim((string)$fl), $r["resolucion_alta"])
            ->setCellValue('AB'.ltrim((string)$fl), ffec($r["baja"]))
            ->setCellValue('AC'.ltrim((string)$fl), $r["resolucion_baja"])
            ->setCellValue('AD'.ltrim((string)$fl), $r["cantidad"]);
 	    $dis=registros("select nombre,deno from dispositivos left join tablas on tablas.tipo='DITIP' and valo=tipo_dispositivo where dispositivos.baja is null and ong=".$r["id"]." order by tipo_dispositivo, nombre");
	  		
	    $can=0;
	    while($d=mysqli_fetch_assoc($dis)){
		$can=$can+1;
  	 	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.chr(ord('D')+$can).ltrim((string)$fl), $d["nombre"]." ".$d["deno"]);

                
	    };

}
for($col='B'; $col<= 'Z'; $col++){
	ajusta($col);
};
ajusta("AA");
ajusta("AB");
for($col='C'; $col<= 'I'; $col++){
	ajusta("A".$col);
};

 $fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
;
$spreadsheet->getActiveSheet()->setTitle('ONGS');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Ongs.xlsx';

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

function ffis($fre){
 if($fre=="0"){return "No se fiscaliza";};
 if($fre=="6"){return "Semestral";};
 if($fre=="12"){return "Anual";};
 if($fre=="24"){return "Bianual";};
 return $fre;
}
?>



           