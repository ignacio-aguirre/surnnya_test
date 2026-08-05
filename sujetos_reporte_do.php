<?php
session_start();
include("Funciones.php");
$desde=fget("desde");
$hasta=fget("hasta");
ejecute("truncate table temporal_reporte");
// Hogares y AF
$reg=registros("select admi_legajo, case when admi_fami>0 then 'acogimiento' else 'hogares' end as programa from hogares_admision where admi_alta<=".$hasta." and (admi_baja is null or admi_baja>=".$desde.")");
while($r=mysqli_fetch_assoc($reg)){
	actualiza($r["admi_legajo"],$r["programa"]);
};

// Fortalecimiento
$reg=registros("select fv_familias_miembros.legajo from fv_familias_miembros 
  left join fv_participaciones on fv_participaciones.familia=fv_familias_miembros.familia  
  where fv_familias_miembros.legajo is not null and 
  fecha_asignacion<=".$hasta." and (fv_participaciones.fecha_baja is null or fv_participaciones.fecha_baja>=".$desde.")");
while($r=mysqli_fetch_assoc($reg)){
	actualiza($r["legajo"],"fortalecimiento");
};


// PAE
$reg=registros("select legajo from pae_nomina where  f_cons_inf<=".$hasta." and (f_baja is null or f_baja>=".$desde.")");
while($r=mysqli_fetch_assoc($reg)){
	actualiza($r["legajo"],"pae");
};


// Salud
$reg=registros("select legajo from es_participaciones where  fecha_ingreso<=".$hasta." and (fecha_fin is null or fecha_fin>=".$desde.")");
while($r=mysqli_fetch_assoc($reg)){
  actualiza($r["legajo"],"salud");
};

error_reporting(E_STRICT);
require_once "PHPExcel.php";
$objPHPExcel = new PHPExcel();
$objPHPExcel->
    getProperties()
        ->setCreator("SURNNYA")
        ->setTitle("NNA y Programas")
        ->setDescription("Documento generado con SURNNYA")
        ->setKeywords("programas")
        ->setCategory("reportes");
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Apellido y Nombre')
            ->setCellValue('B1', 'DNI')
            ->setCellValue('C1', 'RIB')
            ->setCellValue('D1', 'Fecha Nac.')
            ->setCellValue('E1', 'Edad (hoy)')
            ->setCellValue('F1', 'Hogares')
            ->setCellValue('G1', 'PAF')
            ->setCellValue('H1', 'Fort. Vinculos')
            ->setCellValue('I1', 'PAE')
            ->setCellValue('J1', 'Eq Salud');
   $sql="select *, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as eda from temporal_reporte left join sujetos on temporal_reporte.legajo=sujetos.legajo 
   order by apellidos,nombres ";
   $reg=registros($sql);
   $nnya=0;
   $hog=0;
   $paf=0;
   $fv=0;
   $pae=0;
   $sal=0;
   
   $fl=1;
   while($r=mysqli_fetch_assoc($reg)){
	 $fl=$fl+1;

	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["Apellidos"]."  , ".$r["Nombres"])
 	    ->setCellValue('B'.ltrim((string)$fl), $r["SujetosDNI"])	
 	    ->setCellValue('C'.ltrim((string)$fl), rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]))	
 	    ->setCellValue('D'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
 	    ->setCellValue('E'.ltrim((string)$fl), $r["eda"])
 	    ->setCellValue('F'.ltrim((string)$fl), $r["hogares"])
 	    ->setCellValue('G'.ltrim((string)$fl), $r["acogimiento"])	
 	    ->setCellValue('H'.ltrim((string)$fl), $r["fortalecimiento"])	
 	    ->setCellValue('I'.ltrim((string)$fl), $r["pae"])	
            ->setCellValue('J'.ltrim((string)$fl), $r["salud"]);
         $nnya=$nnya+1;
         $hog=$hog+$r["hogares"];
         $paf=$paf+$r["acogimiento"];
         $fv=$fv+$r["fortalecimiento"];
         $pae=$pae+$r["pae"];
         $sal=$sal+$r["salud"];
         
	
  };
  $fl=$fl+1;
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "Totales")
            ->setCellValue('B'.ltrim((string)$fl), $nnya)
            ->setCellValue('F'.ltrim((string)$fl), $hog)
            ->setCellValue('G'.ltrim((string)$fl), $paf)
            ->setCellValue('H'.ltrim((string)$fl), $fv)
            ->setCellValue('I'.ltrim((string)$fl), $pae)
            ->setCellValue('J'.ltrim((string)$fl), $sal);

 			
$fl=$fl+2;
  $objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),axel("Usuario ".$_SESSION["glusua"]));
	
$fl=$fl+2;
  $objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Desde ".substr($desde,-2)."/".substr($desde,4,2)."/".substr($desde,0,4))
	->setCellValue('B'.ltrim((string)$fl),"Hasta ".substr($hasta,-2)."/".substr($hasta,4,2)."/".substr($hasta,0,4));



for($col='A'; $col<= 'J'; $col++){
	ajusta($col);
};

$objPHPExcel->getActiveSheet()->setTitle('NNA y Programas');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="nna_programas.xls"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;


function ajusta($r){
global $objPHPExcel;
$objPHPExcel->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
};

           

function actualiza($leg,$prog){
 $id=un_campo("select id from temporal_reporte where legajo=".$leg);
 if(!$id>0) {$id=inserte("insert into temporal_reporte(legajo,hogares,acogimiento,fortalecimiento,pae,casajoven,salud) values(".$leg.",0,0,0,0,0,0)");};
 ejecute("update temporal_reporte set ".$prog."=1 where id=".$id);
}
?>
