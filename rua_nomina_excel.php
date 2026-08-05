<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Registro')
            ->setCellValue('B1', 'Apellidos')
            ->setCellValue('C1', 'Nombres')
            ->setCellValue('D1', 'DNI')
            ->setCellValue('E1', 'Sexo s/DNI')
            ->setCellValue('F1', 'CUIL')
            ->setCellValue('G1', 'Fecha_Nac')
	        ->setCellValue('H1', 'Edad')
            ->setCellValue('I1', 'Nacionalidad')
            ->setCellValue('J1', 'Provincia')
            ->setCellValue('K1', 'Departamento')
            ->setCellValue('L1', 'Localidad')
            ->setCellValue('M1', 'Calle y altura')
            ->setCellValue('N1', utf8_encode('Teléfono celular'))
            ->setCellValue('O1', utf8_encode('Correo electrónico'))
            ->setCellValue('P1', utf8_encode('F.inclusión'))
            ->setCellValue('Q1', 'Intereses')
            ->setCellValue('R1', 'Competencias')
            ->setCellValue('S1', 'F.Ingreso')
            ->setCellValue('T1', 'Poder')
            ->setCellValue('U1', 'Organismo')
            ->setCellValue('V1', 'F.baja')
            ->setCellValue('W1', 'Motivo baja')
            ->setCellValue('X1', 'Comentarios')
            
;
$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:X1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select rua_nomina.*, sujetos_pae.*, sujetos.legajo , sujetos.apellidos, sujetos.nombres, sujetos.telefonos, sujetos.email, 
edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,curdate()) as edad,
 sujetosdni, cuil, f_nacimiento, sexo, paises.descripcion as nacionalidad,tablas.deno as dmotivo, rua_nomina.id as idregistro ,
    tpod.deno as dpoder 
from rua_nomina
   left join sujetos on rua_nomina.legajo=sujetos.legajo 
   left join sujetos_pae on rua_nomina.legajo=sujetos_pae.legajo 
   left join paises on nacionalidad=idpaises
   left join tablas on tablas.tipo='BRUA' and tablas.valo=motivo_baja
   left join tablas tpod on tpod.tipo='PRUA' and tpod.valo=poder
   order by registro";
   $reg=registros($sql);
   $nnya=0;
   $fl=1;
   while($r=mysqli_fetch_assoc($reg)){
	  	$fl=$fl+1;
        
    $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["registro"])
            ->setCellValue('B'.ltrim((string)$fl), $r["apellidos"])
            ->setCellValue('C'.ltrim((string)$fl), $r["nombres"])
            ->setCellValue('D'.ltrim((string)$fl), $r["sujetosdni"])
            ->setCellValue('E'.ltrim((string)$fl), si($r["sexo"]=="M","Masculino",si($r["sexo"]=="F","Femenino",$r["sexo"])))
            ->setCellValue('F'.ltrim((string)$fl), cuil($r["cuil"]))
            ->setCellValue('G'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
            ->setCellValue('H'.ltrim((string)$fl), $r["edad"])
            ->setCellValue('I'.ltrim((string)$fl), $r["nacionalidad"])
            ->setCellValue('J'.ltrim((string)$fl), utf8_encode($r["provincia_domicilio"]))
            ->setCellValue('K'.ltrim((string)$fl), utf8_encode($r["partido_domicilio"]))
            ->setCellValue('L'.ltrim((string)$fl), utf8_encode($r["localidad_domicilio"]))
            ->setCellValue('M'.ltrim((string)$fl), utf8_encode($r["callenro_domicilio"]))
            ->setCellValue('N'.ltrim((string)$fl), $r["telefonos"])
 	        ->setCellValue('O'.ltrim((string)$fl), $r["email"])
            ->setCellValue('P'.ltrim((string)$fl), ffec($r["f_ingreso"]))
            ->setCellValue('Q'.ltrim((string)$fl), utf8_encode($r["intereses"]))
            ->setCellValue('R'.ltrim((string)$fl), utf8_encode($r["competencias"]))
            ->setCellValue('S'.ltrim((string)$fl), ffec($r["f_alta_laboral"]))
            ->setCellValue('T'.ltrim((string)$fl), $r["dpoder"])
            ->setCellValue('U'.ltrim((string)$fl), utf8_encode($r["organismo"]))
            ->setCellValue('V'.ltrim((string)$fl), ffec($r["f_baja"]))
            ->setCellValue('W'.ltrim((string)$fl), $r["dmotivo"])
            ->setCellValue('X'.ltrim((string)$fl), $r["comentarios"])
            
 	    ;
         $nnya=$nnya+1;
       
  };
  
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"])
	;
	



for($col='A'; $col<= 'X'; $col++){
	ajusta($col);
};

$spreadsheet->getActiveSheet()->setTitle('RUA Nomina');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'RUANomina.xlsx';

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
};

?>
           