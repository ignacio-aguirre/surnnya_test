<?php
require_once("PHPExcel.php");
include("../trimestrales/funciones.php"); 
session_start();
$anio=nget("anio");
$trimestre=nget("trimestre");
$ut=nget("ut");

$ruta="../trimestrales/importacion/PlantillaVAnual.xls";

$oE = PHPExcel_IOFactory::load($ruta);
$oE->setActiveSheetIndex(0);
$tri=registros("select trimestrales.id,nombre,apellidos, nombres,f_nacimiento,rib_anio,rib_numero,rib_reparticion
from trimestrales left join sujetos on sujetos.legajo=trimestrales.legajo_surnnya 
left join dispositivos on trimestrales.hogar=dispositivos.id 
where anio=".$anio." and trimestre=".$trimestre." and unidad_tecnica=".$ut.
" order by nombre,apellidos, nombres");
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
  $oE->setActiveSheetIndex(0)
  ->setCellValue('A'.ltrim($f),$t["nombre"])
  ->setCellValue("B".ltrim($f),$trimestre)
 ->setCellValue("C".ltrim($f),rib2($t))
 ->setCellValue("D".ltrim($f),$t["apellidos"].", ".$t["nombres"])
 ->setCellValue("E".ltrim($f),ffec($t["f_nacimiento"]))
 ;
 $i=un_registro("select * from trim_salud_fisica where trimestral=".$t["id"]);
 $oE->setActiveSheetIndex(0)
 ->setCellValue("AQ".ltrim($f),snb($i["obra_social"]))
 ->setCellValue("AR".ltrim($f),snb($i["en_tratamiento"]))
 ->setCellValue("AS".ltrim($f),si($i["juris_ef1"]<"1","",d_t(si($i["juris_ef1"]=="1","ESAC","ESAB"),$i["ef_1"])))
 ->setCellValue("AT".ltrim($f),si($i["juris_ef2"]<"1","",d_t(si($i["juris_ef2"]=="1","ESAC","ESAB"),$i["ef_2"])))
 ->setCellValue("AU".ltrim($f),si($i["juris_ef3"]<"1","",d_t(si($i["juris_ef3"]=="1","ESAC","ESAB"),$i["ef_3"])))
 ->setCellValue("AV".ltrim($f),d_t("ESPEC",$i["especialidad_1"]))
 ->setCellValue("AW".ltrim($f),d_t("ESPEC",$i["especialidad_2"]))
 ->setCellValue("AX".ltrim($f),d_t("ESPEC",$i["especialidad_3"]))
 ->setCellValue("AY".ltrim($f),d_t("ESPEC",$i["especialidad_4"]))
 ->setCellValue("AZ".ltrim($f),si($i["juris_odonto"]<"1","",d_t(si($i["juris_odonto"]=="1","ESAC","ESAB"),$i["ef_odonto"])))
 ->setCellValue("BA".ltrim($f),$i["obse_odonto"])
 ->setCellValue("BB".ltrim($f),snb($i["calendario_vacunacion"]))
 ->setCellValue("BC".ltrim($f),snb($i["internacion"]))
 ->setCellValue("BD".ltrim($f),snb($i["plan_medicacion"]))
 ;

 $i=un_registro("select * from trim_salud_mental where trimestral=".$t["id"]);
 $oE->setActiveSheetIndex(0)
 ->setCellValue("BT".ltrim($f),snb($i["plan_medicacion"]))
 ->setCellValue("BW".ltrim($f),snb($i["sm_internacion"]))
 ->setCellValue("BY".ltrim($f),si($i["at_tuvo"]=="1","Si",""))
 ->setCellValue("BZ".ltrim($f),d_t("ATPSM",$i["at_prestador"]))
 ->setCellValue("CA".ltrim($f),$i["at_esquema"]);
 
 $i=un_registro("select * from trim_discapacidad where trimestral=".$t["id"]);
 $oE->setActiveSheetIndex(0)
 ->setCellValue("CB".ltrim($f),d_t("DIS_TIPO",$i["tipo_discapacidad"]))
 ->setCellValue("CC".ltrim($f),snb($i["certificado_discapacidad"]))
 ->setCellValue("CD".ltrim($f),ffec($i["cd_vencimiento"]))
 ->setCellValue("CG".ltrim($f),si($i["pension"]=="1","Si",si($i["pension"]=="2","No",si($i["pension"]=="3","En tramite",""))))
 ->setCellValue("CH".ltrim($f),d_t("DIS_PET",$i["pension_estado_tramite"]))
 ->setCellValue("CI".ltrim($f),snb($i["incluir_salud"]))
;
$i=un_registro("select * from trim_educacion where trimestral=".$t["id"]);
 $oE->setActiveSheetIndex(0)
 ->setCellValue("CJ".ltrim($f),snb($i["edu_asiste"]))
  ->setCellValue("CO".ltrim($f),d_t("ETIPO",$i["edu_tipo_establecimiento"]))
 ->setCellValue("CP".ltrim($f),d_t("ENIVE",$i["edu_nivel"]))
 ->setCellValue("CQ".ltrim($f),snb($i["edu_asiste"]))
 ->setCellValue("CR".ltrim($f),snb($i["edu_regular"]))
 ->setCellValue("CS".ltrim($f),d_t("EGRAD",$i["edu_grado"]))
 ->setCellValue("CT".ltrim($f),d_t("ETURN",$i["edu_turno"]))
 ->setCellValue("CU".ltrim($f),snb($i["edu_apoyo"]))
 ->setCellValue("CV".ltrim($f),$i["edu_apoyo_efector"])
 ->setCellValue("CW".ltrim($f),d_t("EGRAD",$i["edu_ultimo_grado"]))
 ->setCellValue("CX".ltrim($f),$i["edu_ultimo_anio"])
 ->setCellValue("CY".ltrim($f),d_t("EOOFE",$i["edu_otras_ofertas"]))
 ;

 
 $f=$f+1;
};

 $oE->setActiveSheetIndex(1)
 ->setCellValue("B1",$anio)
 ->setCellValue("A2","Trimestre")
 ->setCellValue("B2",$trimestre)
 ->setCellValue("B3",$_SESSION["DiaHoy"]);
 
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="vuelco'.$anio."-".$trimestre.'.xls"');
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

?>



           