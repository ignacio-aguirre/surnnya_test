<?php
require_once("PHPExcel.php");
include("../trimestrales/funciones.php");
session_start();
$anio=nget("anio");
$ruta="../trimestrales/importacion/PlantillaALegal.xls";

$oE = PHPExcel_IOFactory::load($ruta);
$oE->setActiveSheetIndex(0);
$tri=registros("select trimestrales.id,trimestre,nombre,apellidos, nombres 
from trimestrales left join sujetos on sujetos.legajo=trimestrales.legajo_surnnya 
left join dispositivos on trimestrales.hogar=dispositivos.id 
where anio=".$anio." order by nombre,trimestre,apellidos, nombres");
$f=2;
while($t=mysqli_fetch_assoc($tri)){
 $i=un_registro("select * from trim_juridicos where trimestral=".$t["id"]);
 pon($oE,"A",$f,$t["nombre"]);
 pon($oE,"B",$f,$i["trimestre"]);
 pon($oE,"C",$f,$t["apellidos"].", ".$t["nombres"]);
 pon($oE,"D",$f,d_ts("CM",$i["defensoria_zonal"]));
 pon($oE,"E",$f,d_t("ZP",$i["zona_provincial"]));
 pon($oE,"F",$f,$i["zp_detalle"]);
 pon($oE,"G",$f,snb($i["medida_excepcional"]));
 pon($oE,"H",$f,snb($i["medida_cautelar"]));
 pon($oE,"I",$f,$i["juzgado_civil"]);
 pon($oE,"J",$f,d_t("TJ",$i["juzgado_otro"]));
 pon($oE,"K",$f,$i["juzgado_otro_q"]);
 pon($oE,"L",$f,d_n($i["defensoria_nacional"],"Vacio"));
 pon($oE,"M",$f,$i["defensor"]);
 pon($oE,"N",$f,d_n($i["tutoria"],"Vacio"));
 pon($oE,"O",$f,$i["tutor"]);
 pon($oE,"P",$f,snb($i["abogado_ninio"]));
 pon($oE,"Q",$f,$i["abogado"]);
 pon($oE,"R",$f,d_t("ANP",$i["pertenencia"]));
 pon($oE,"S",$f,snb($i["ad_decretada"]));
 pon($oE,"T",$f,snb($i["guardas_fallidas"]));
 pon($oE,"U",$f,ffec($i["guardas_fult_vinculacion"]));
 $f=$f+1;
};

 $oE->setActiveSheetIndex(1);
 pon($oE,"B",1,$anio);
 pon($oE,"B",3,$_SESSION["DiaHoy"]);
 $oE->setActiveSheetIndex(0);
  for ($col = 'A'; $col <= 'T'; $col++) { 
        $oE->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);         
  };
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="admlegal'.$anio."-".'.xls"');
  header('Cache-Control: max-age=0');
  $objWriter=PHPExcel_IOFactory::createWriter($oE,'Excel5');
  $objWriter->save('php://output');
exit;


function d_t($tipo,$valor){
return un_campo("select descripcion from tablas_semestrales where tipo=".tsql($tipo)." and valor=".nulea($valor));
}
function d_ts($tipo,$valor){
return un_campo("select deno from tablas where tipo=".tsql($tipo)." and valo=".nulea($valor)); 
}

function d_n($valor,$cero){
return si($valor=="0",$cero,$valor);
}
function pon($obj,$col,$fil,$t){
return e_put($obj,$col.ltrim((string)$fil),$t);
}
?>



           