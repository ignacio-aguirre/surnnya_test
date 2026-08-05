<?php
require_once("PHPExcel.php");
include("../trimestrales/funciones.php");
session_start();
$anio=nget("anio");
$ruta="../trimestrales/importacion/PlantillaIdentidad.xls";
$oE = PHPExcel_IOFactory::load($ruta);
$oE->setActiveSheetIndex(0);
$tri=registros("select trimestrales.id,trimestre,nombre,apellidos, nombres,f_nacimiento,rib_anio,rib_numero,rib_reparticion
from trimestrales left join sujetos on sujetos.legajo=trimestrales.legajo_surnnya 
left join dispositivos on trimestrales.hogar=dispositivos.id 
where anio=".$anio."  order by nombre,trimestre,apellidos, nombres");
$f=2;
while($t=mysqli_fetch_assoc($tri)){
  $i=un_registro("select trim_identidad.*,pnac.descripcion as p_nac , ulrf.descripcion as p_urf,
ofam.descripcion as p_ofa,prnac.descripcion as prov_nac, profam.descripcion as prov_ofam 
from trim_identidad 
  left join paises pnac on pnac.idpaises=pais_nacimiento 
  left join paises ulrf on ulrf.idpaises=pais_ultresfam
  left join paises ofam on ofam.idpaises=pais_origenfam
  left join provincias prnac on prnac.idprovincias=provincia_nacimiento 
  left join provincias profam on profam.idprovincias=provincia_origenfam  
where trimestral=".$t["id"]);
 $oE->setActiveSheetIndex(0);
  pon($oE,"A",$f,$t["nombre"]);
 pon($oE,"B",$f,$t["trimestre"]);
 pon($oE,"C",$f,rib2($t));
 pon($oE,"D",$f,$t["apellidos"].", ".$t["nombres"]);
 pon($oE,"E",$f,ffec($t["f_nacimiento"]));
 pon($oE,"F",$f,$i["otros_nombres"]);
 pon($oE,"G",$f,$i["p_nac"]);
 pon($oE,"H",$f,$i["prov_nac"]);
 pon($oE,"I",$f,$i["p_urf"]);
 pon($oE,"J",$f,$i["provincia_ultresfam"]);
 pon($oE,"K",$f,$i["localidad_ultresfam"]);
 pon($oE,"L",$f,$i["barrio_ultresfam"]);
 pon($oE,"M",$f,$i["partido_ultresfam"]);

 pon($oE,"N",$f,$i["p_ofa"]);
 pon($oE,"O",$f,$i["prov_ofam"]);
 pon($oE,"P",$f,d_t("GENERO",$i["identidad_genero"]));
 pon($oE,"Q",$f,snb($i["partida"]));
 pon($oE,"R",$f,snb($i["partida_ubicacion"]));
 pon($oE,"S",$f,snb($i["documento_posee"]));
 pon($oE,"T",$f,d_t("TD",$i["documento_tipo"]));
 pon($oE,"U",$f,$i["documento_numero"]);
 pon($oE,"V",$f,d_t("UBICACION",$i["documento_ubicacion"]));

 
 $f=$f+1;
};

 $oE->setActiveSheetIndex(1);
 pon($oE,"B",1,$anio);
 pon($oE,"B",3,$_SESSION["DiaHoy"]);
 $oE->setActiveSheetIndex(0);
  for ($col = 'A'; $col <= 'V'; $col++) { 
        $oE->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);         
  };
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="identidad'.$anio.'.xls"');
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



           