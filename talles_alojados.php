<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$hogar=$_SESSION["glhogar"];
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Apellido y Nombre')
            ->setCellValue('B1', 'Edad (hoy)')
            ->setCellValue('C1', 'Sexo')
            ->setCellValue('D1', 'Genero')
            ->setCellValue('E1', 'Dispositivo')
	        ->setCellValue('F1', 'Ropa interior')
            ->setCellValue('G1', 'Medias')
            ->setCellValue('H1', 'Remeras')
            ->setCellValue('I1', 'Buzos')
            ->setCellValue('J1', 'Camperas')
            ->setCellValue('K1', 'Pantalones')
            ->setCellValue('L1', 'Zapatillas')
            ->setCellValue('M1', 'Guardapolvos')
            ->setCellValue('N1', 'Pintorcitos')
            ->setCellValue('O1', 'Pecheras')
;
ejecute("truncate temporal_talles");
$sql="select sujetos.legajo , Apellidos, Nombres, sexo,genero, edc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad,
      sujetos_talles.*, nombre 
       from hogares_admision
       	left join dispositivos on admi_hogar=dispositivos.id 
       	left join sujetos on admi_legajo=sujetos.legajo
       	left join sujetos_talles on admi_legajo=sujetos_talles.legajo
	 where admi_hogar=".$hogar." and admi_alta is not null and admi_baja is null
       	 order by nombre, Apellidos, Nombres";
	$conn = registros($sql);
	$f=1; 
	while ($r = mysqli_fetch_assoc($conn)) {
         $f=$f+1;
	 $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('A'.ltrim((string)$f),$r["Apellidos"]." , ".$r["Nombres"])
 		->setCellValue('B'.ltrim((string)$f),$r["edad"])
 		->setCellValue('C'.ltrim((string)$f),$r["sexo"])
        ->setCellValue('D'.ltrim((string)$f),$r["genero"])
 		->setCellValue('E'.ltrim((string)$f),$r["nombre"])
        ->setCellValue('F'.ltrim((string)$f),$r["rint"])
        ->setCellValue('G'.ltrim((string)$f),$r["medi"])
        ->setCellValue('H'.ltrim((string)$f),$r["reme"])
        ->setCellValue('I'.ltrim((string)$f),$r["buzo"])
        ->setCellValue('J'.ltrim((string)$f),$r["camp"])
        ->setCellValue('K'.ltrim((string)$f),$r["pant"])
        ->setCellValue('L'.ltrim((string)$f),$r["zapa"])
        ->setCellValue('M'.ltrim((string)$f),$r["guar"])
        ->setCellValue('N'.ltrim((string)$f),$r["pint"])
        ->setCellValue('O'.ltrim((string)$f),$r["pech"])
 		
         ;
         acumula($r);
     };	
  
  $f=$f+1;
	 $spreadsheet->setActiveSheetIndex(0)
 		->setCellValue('A'.ltrim((string)$f),($f-2)." NNYA");
  $f=$f+1;
    $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$f), 'Rubro')
            ->setCellValue('B'.ltrim((string)$f), 'SexoGenero')
            ->setCellValue('C'.ltrim((string)$f), 'Talle')
            ->setCellValue('D'.ltrim((string)$f), 'Cantidad');
        
     $reg=registros("select * from temporal_talles order by rubro,sexogenero,talle");
     while ($r = mysqli_fetch_assoc($reg)) {
         $f=$f+1;
         $spreadsheet->setActiveSheetIndex(0)
         ->setCellValue('A'.ltrim((string)$f),nombre($r["rubro"]))
         ->setCellValue('B'.ltrim((string)$f),$r["sexogenero"])
         ->setCellValue('C'.ltrim((string)$f),$r["talle"])
         ->setCellValue('D'.ltrim((string)$f),$r["cantidad"]);
     };    
 	 $f=$f+2;
       $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$f),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($f+1)),"Usuario ".$_SESSION["glusua"]);
for($col='A'; $col<= 'O'; $col++){
	ajusta($col);
};
$spreadsheet->getActiveSheet()->setTitle('AlojadosTalles');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'Talles.xlsx';

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
function acumula($r){
    if($r["rint"]!=""){
        acum("rint",$r["sexo"].$r["genero"],$r["rint"]);
    };
    if($r["medi"]!=""){
        acum("medi",$r["sexo"].$r["genero"],$r["medi"]);
    };
    if($r["reme"]!=""){
        acum("reme",$r["sexo"].$r["genero"],$r["reme"]);
    };
    if($r["buzo"]!=""){
        acum("buzo",$r["sexo"].$r["genero"],$r["buzo"]);
    };
    if($r["camp"]!=""){
        acum("camp",$r["sexo"].$r["genero"],$r["camp"]);
    };
    if($r["pant"]!=""){
        acum("pant",$r["sexo"].$r["genero"],$r["pant"]);
    };
    if($r["zapa"]!=""){
        acum("zapa",$r["sexo"].$r["genero"],$r["zapa"]);
    };
    if($r["guar"]!=""){
        acum("guar",$r["sexo"].$r["genero"],$r["guar"]);
    };
    if($r["pint"]!=""){
        acum("pint",$r["sexo"].$r["genero"],$r["pint"]);
    };
    if($r["pech"]!=""){
        acum("pech",$r["sexo"].$r["genero"],$r["pech"]);
    };
}
function acum($rubro,$sexogenero,$talle){
    $id=un_campo("select id from temporal_talles where rubro=".tsql($rubro)." and sexogenero=".tsql($sexogenero)." and talle=".tsql($talle));
    if(!$id>"0") $id=inserte("insert into temporal_talles(rubro,sexogenero,talle) values(".tsql($rubro).",".tsql($sexogenero).",".tsql($talle).")");
    ejecute("update temporal_talles set cantidad=cantidad+1 where id=".$id);
}      
function nombre($rub){
    if($rub=="rint") return "Ropa interior";
    if($rub=="medi") return "Medias";
    if($rub=="reme") return "Remeras";
    if($rub=="buzo") return "Buzos";
    if($rub=="camp") return "Camperas";
    if($rub=="pant") return "Pantalones";
    if($rub=="zapa") return "Zapatillas";
    if($rub=="guar") return "Guardapolvos";
    if($rub=="pint") return "Pintorcitos";
    if($rub=="pech") return "Pecheras";
}
?>
