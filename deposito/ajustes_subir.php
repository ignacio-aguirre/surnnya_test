<?php
include("funciones.php");
require_once("PHPExcel.php");

session_start();
$numearch=(string) (un_campo("select ultnumero from numeradores where codigo='ARCH_TEMP'")+1); 
$tamano = $_FILES["archivo"]['size'];
$tipo = $_FILES["archivo"]['type'];
$archivo = $_FILES["archivo"]['name'];
$destino='archivos/temp/ajuste'.$numearch.'.xls';
if (copy($_FILES['archivo']['tmp_name'],$destino)) {
   ejecute("update numeradores set ultnumero=".$numearch." where codigo='ARCH_TEMP'");
   $sid=tsql(session_id());
   ejecute("delete from temporal_ajustes where sesion=".$sid);
   $oE = PHPExcel_IOFactory::load($destino);
   $oE->setActiveSheetIndex(0);
   $fecha=e_get($oE,"E1").e_get($oE,"F1").e_get($oE,"G1");
   if($fecha==""){Redirect("error");};
   $f=2;

   while(e_get($oE,'A'.ltrim((string)$f))!=""){
 	$desc=e_get($oE,'B'.ltrim((string)$f));
 	$cant=e_get($oE,'C'.ltrim((string)$f));
        $mini=e_get($oE,'D'.ltrim((string)$f));
 	$arti=un_campo("select idarticulos from articulos where baja is null and descripcion=".tsql($desc));
 	if($arti>0 && $cant!=""){
		e_put($oE,'E'.ltrim((string)$f), "OK");
		 inserte("insert into temporal_ajustes(sesion,articulo,cantidad,numearch,fecha) values(".$sid.",".$arti.",".$cant.",".$numearch.",".$fecha.")"); 		
	};
        
	$f=$f+1;
   };
	$_SESSION["arch_temp"]=$numearch;
	$oE->getActiveSheet()->setTitle('Proceso Ajuste');
	$oE->setActiveSheetIndex(0);

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="post'.$numearch.'.xls"');
	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFactory::createWriter($oE,'Excel5');
	$objWriter->save('php://output');
	
	exit;
}else{die("error");
};
?>