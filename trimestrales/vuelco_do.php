<?php
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
include("funciones.php");
session_start();
$hogar=$_SESSION["hogar"];
$anio=nget("anio");
$trimestre=nget("trimestre");
$ruta="importacion/PlantillaVuelco.xls";
$oE = IOFactory::load($ruta);

$oE->setActiveSheetIndex(0);
$tri=registros("select trimestrales.id,nombre,apellidos, nombres,f_nacimiento,rib_anio,rib_numero,rib_reparticion from trimestrales left join sujetos on sujetos.legajo=trimestrales.legajo_surnnya
 left join dispositivos on trimestrales.hogar=dispositivos.id where hogar=".$hogar." and anio=".$anio." and trimestre=".$trimestre.
" order by apellidos, nombres");
$f=2;
while($t=mysqli_fetch_assoc($tri)){
 
 $i=un_registro("select * from trim_identidad where trimestral=".$t["id"]);
 if(!is_null($i)){
 $oE->setActiveSheetIndex(0);
 pon($oE,"A",$f,$t["nombre"]);
 pon($oE,"B",$f,rib($t["rib_anio"],$t["rib_numero"],$t["rib_reparticion"]));
 pon($oE,"C",$f,$t["apellidos"].", ".$t["nombres"]);
 pon($oE,"D",$f,ffec($t["f_nacimiento"]));
 pon($oE,"E",$f,$i["otros_nombres"]);
 pon($oE,"F",$f,un_campo("select descripcion from paises where idpaises=".si($i["pais_nacimiento"]=="","0",$i["pais_nacimiento"])));
 pon($oE,"G",$f,un_campo("select descripcion from provincias where idprovincias=".si($i["provincia_nacimiento"]=="","0",$i["provincia_nacimiento"])));
 pon($oE,"H",$f,un_campo("select descripcion from paises where idpaises=".si($i["pais_ultresfam"]=="","0",$i["pais_ultresfam"])));
 pon($oE,"I",$f,un_campo("select concat(grupo,' ',descripcion) from localidades where idlocalidades=".si($i["loc_ultresfam"]=="","0",$i["loc_ultresfam"])));
 pon($oE,"J",$f,un_campo("select descripcion from paises where idpaises=".si($i["pais_origenfam"]=="","0",$i["pais_origenfam"])));
 pon($oE,"K",$f,un_campo("select descripcion from provincias where idprovincias=".si($i["provincia_origenfam"]=="","0",$i["provincia_origenfam"])));
 pon($oE,"L",$f,d_t("GENERO",$i["identidad_genero"]));
 pon($oE,"M",$f,snb($i["partida"]));
 pon($oE,"N",$f,snb($i["partida_ubicacion"]));
 pon($oE,"O",$f,snb($i["documento_posee"]));
 pon($oE,"P",$f,d_t("TD",$i["documento_tipo"]));
 pon($oE,"Q",$f,$i["documento_numero"]);
 pon($oE,"R",$f,d_t("UBICACION",$i["documento_ubicacion"]));
 pon($oE,"S",$f,$i["informacion_familiar"]);
};
 $i=un_registro("select * from trim_juridicos where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"T",$f,d_ts("CM",$i["defensoria_zonal"]));
 pon($oE,"U",$f,d_t("ZP",$i["zona_provincial"]));
 pon($oE,"V",$f,$i["zp_detalle"]);
 pon($oE,"W",$f,snb($i["medida_excepcional"]));
 pon($oE,"X",$f,snb($i["medida_cautelar"]));
 pon($oE,"Y",$f,$i["juzgado_civil"]);
 pon($oE,"Z",$f,d_t("TJ",$i["juzgado_otro"]));
 pon($oE,"AA",$f,$i["juzgado_otro_q"]);
 pon($oE,"AB",$f,d_n($i["defensoria_nacional"],"Vacio"));
 pon($oE,"AC",$f,$i["defensor"]);
 pon($oE,"AD",$f,d_n($i["tutoria"],"Vacio"));
 pon($oE,"AE",$f,$i["tutor"]);
 pon($oE,"AF",$f,snb($i["abogado_ninio"]));
 pon($oE,"AG",$f,$i["abogado"]);
 pon($oE,"AH",$f,d_t("ANP",$i["pertenencia"]));
 pon($oE,"AI",$f,snb($i["ad_decretada"]));
 pon($oE,"AJ",$f,snb($i["guardas_fallidas"]));
 pon($oE,"AK",$f,ffec($i["guardas_fult_vinculacion"]));
 pon($oE,"AL",$f,un_campo("select descripcion from trim_ingreso where trimestral=".$t["id"]));
 pon($oE,"AM",$f,un_campo("select descripcion from trim_convivencial where trimestral=".$t["id"]));
};
 $i=un_registro("select * from trim_salud_fisica where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"AN",$f,snb($i["cobertura_portenia"]));
 pon($oE,"AO",$f,snb($i["obra_social"]));
 pon($oE,"AP",$f,snb($i["en_tratamiento"]));
 pon($oE,"AQ",$f,si($i["juris_ef1"]<"1","",d_t(si($i["juris_ef1"]=="1","ESAC","ESAB"),$i["ef_1"])));
 pon($oE,"AR",$f,si($i["juris_ef2"]<"1","",d_t(si($i["juris_ef2"]=="1","ESAC","ESAB"),$i["ef_2"])));
 pon($oE,"AS",$f,si($i["juris_ef3"]<"1","",d_t(si($i["juris_ef3"]=="1","ESAC","ESAB"),$i["ef_3"])));
 pon($oE,"AT",$f,d_t("ESPEC",$i["especialidad_1"]));
 pon($oE,"AU",$f,d_t("ESPEC",$i["especialidad_2"]));
 pon($oE,"AV",$f,d_t("ESPEC",$i["especialidad_3"]));
 pon($oE,"AW",$f,d_t("ESPEC",$i["especialidad_4"]));
 pon($oE,"AX",$f,si($i["juris_odonto"]<"1","",d_t(si($i["juris_odonto"]=="1","ESAC","ESAB"),$i["ef_odonto"])));
 pon($oE,"AY",$f,$i["obse_odonto"]);
 pon($oE,"AZ",$f,snb($i["calendario_vacunacion"]));
 pon($oE,"BA",$f,snb($i["internacion"]));
 pon($oE,"BB",$f,snb($i["plan_medicacion"]));
 pon($oE,"BC",$f,snb($i["plan_detalle"]));
 pon($oE,"BD",$f,$i["sf_observaciones"]);
};
 $i=un_registro("select * from trim_salud_mental where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"BE",$f,snb($i["en_tratamiento"]));
 pon($oE,"BF",$f,si($i["juris_em1"]<"1","",d_t(si($i["juris_em1"]=="1","ESMEN","ESAB"),$i["em_1"])));
 pon($oE,"BG",$f,$i["pm_1"]);
 pon($oE,"BH",$f,si($i["juris_em2"]<"1","",d_t(si($i["juris_em2"]=="1","ESMEN","ESAB"),$i["em_2"])));
 pon($oE,"BI",$f,$i["pm_2"]);
 pon($oE,"BJ",$f,si($i["juris_em3"]<"1","",d_t(si($i["juris_em3"]=="1","ESMEN","ESAB"),$i["em_3"])));
 pon($oE,"BK",$f,$i["pm_3"]);
 pon($oE,"BL",$f,si($i["juris_em4"]<"1","",d_t(si($i["juris_em4"]=="1","ESMEN","ESAB"),$i["em_4"])));
 pon($oE,"BM",$f,$i["pm_4"]);
 pon($oE,"BN",$f,d_t("ESPSM",$i["espec_sm1"]));
 pon($oE,"BO",$f,d_t("ESPSM",$i["espec_sm2"]));
 pon($oE,"BP",$f,d_t("ESPSM",$i["espec_sm3"]));
 pon($oE,"BQ",$f,d_t("ESPSM",$i["espec_sm4"]));
 pon($oE,"BR",$f,snb($i["plan_medicacion"]));
 pon($oE,"BS",$f,$i["plan_detalle"]);
 if($i["plan_efector"]=="1") pon($oE,"BT",$f,$i["pm_1"]);
 if($i["plan_efector"]=="2") pon($oE,"BT",$f,$i["pm_2"]);
 if($i["plan_efector"]=="3") pon($oE,"BT",$f,$i["pm_3"]);
 if($i["plan_efector"]=="4") pon($oE,"BT",$f,$i["pm_4"]);
 pon($oE,"BU",$f,snb($i["sm_internacion"]));
 pon($oE,"BV",$f,$i["sm_observaciones"]);
};
 $i=un_registro("select * from trim_discapacidad where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"BW",$f,d_t("DIS_TIPO",$i["tipo_discapacidad"]));
 pon($oE,"BX",$f,snb($i["certificado_discapacidad"]));
 pon($oE,"BY",$f,ffec($i["cd_vencimiento"]));
 pon($oE,"BZ",$f,$i["cd_diagnostico"]);
 pon($oE,"CA",$f,$i["cd_prestaciones"]);
 pon($oE,"CB",$f,si($i["pension"]=="1","Si",si($i["pension"]=="2","No",si($i["pension"]=="3","En tramite",""))));
 pon($oE,"CC",$f,d_t("DIS_PET",$i["pension_estado_tramite"]));
 pon($oE,"CD",$f,snb($i["incluir_salud"]));
};
$i=un_registro("select * from trim_educacion where trimestral=".$t["id"]);
if(!is_null($i)){
 pon($oE,"CE",$f,$i["edu_establecimiento"]);
 pon($oE,"CF",$f,$i["edu_distrito_caba"]);
 pon($oE,"CG",$f,d_t("EMUNI",$i["edu_municipio_pba"]));
 if($i["edu_gestion"]=="1") {pon($oE,"CH",$f,"Estatal");};
 if($i["edu_gestion"]=="2") {pon($oE,"CH",$f,"Privada");};
 if($i["edu_gestion"]=="3") {pon($oE,"CH",$f,"Mixta");};
 pon($oE,"CI",$f,d_t("ETIPO",$i["edu_tipo_establecimiento"]));
 pon($oE,"CJ",$f,d_t("ENIVE",$i["edu_nivel"]));
 pon($oE,"CK",$f,snb($i["edu_asiste"]));
 pon($oE,"CL",$f,snb($i["edu_regular"]));
 pon($oE,"CM",$f,d_t("EGRAD",$i["edu_grado"]));
 pon($oE,"CN",$f,d_t("ETURN",$i["edu_turno"]));
 pon($oE,"CO",$f,snb($i["edu_apoyo"]));
 pon($oE,"CO",$f,$i["edu_apoyo_efector"]);
 pon($oE,"CQ",$f,d_t("EGRAD",$i["edu_ultimo_grado"]));
 pon($oE,"CR",$f,$i["edu_ultimo_anio"]);
 pon($oE,"CS",$f,d_t("EOOFE",$i["edu_otras_ofertas"]));
 pon($oE,"CT",$f,$i["edu_observaciones"]);
};
 $i=un_registro("select * from trim_trayectos where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"CU",$f,d_t("TAFL",$i["tipo_actividad"]));
 pon($oE,"CV",$f,$i["tra_institucion"]);
 pon($oE,"CW",$f,$i["tra_actividad"]);
 pon($oE,"CX",$f,d_t("AFRE",$i["frecuencia"]));
 pon($oE,"CY",$f,d_t("TAFL",$i["tipo_actividad2"]));
 pon($oE,"CZ",$f,$i["tra_institucion2"]);
 pon($oE,"DA",$f,$i["tra_actividad2"]);
 pon($oE,"DB",$f,d_t("AFRE",$i["frecuencia2"]));
 pon($oE,"DC",$f,$i["tra_observaciones"]);
};
 $i=un_registro("select * from trim_actividades where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"DF",$f,d_t("TADRC",$i["tipo_actividad"]));
 pon($oE,"DG",$f,$i["institucion"]);
 pon($oE,"DH",$f,$i["actividad"]);
 pon($oE,"DI",$f,d_t("AFRE",$i["frecuencia"]));
 pon($oE,"DJ",$f,d_t("TADRC",$i["tipo_actividad2"]));
 pon($oE,"DK",$f,$i["institucion2"]);
 pon($oE,"DL",$f,$i["actividad2"]);
 pon($oE,"DM",$f,d_t("AFRE",$i["frecuencia2"]));
 pon($oE,"DN",$f,$i["observaciones"]);
};
$i=un_registro("select * from trim_vinculaciones where trimestral=".$t["id"]);
if(!is_null($i)){
 pon($oE,"DQ",$f,snb($i["vin_tuvo"]));
 pon($oE,"DR",$f,d_t("VQUI",$i["vin_quien"]));
 pon($oE,"DS",$f,d_t("VFRE",$i["vin_frecuencia"]));
 pon($oE,"DT",$f,d_t("VLUG",$i["vin_lugar"]));
 pon($oE,"DU",$f,d_t("VQUI",$i["vin_quien2"]));
 pon($oE,"DV",$f,d_t("VFRE",$i["vin_frecuencia2"]));
 pon($oE,"DW",$f,d_t("VLUG",$i["vin_lugar2"]));
 pon($oE,"DX",$f,d_t("VQUI",$i["vin_quien3"]));
 pon($oE,"DY",$f,d_t("VFRE",$i["vin_frecuencia3"]));
 pon($oE,"DZ",$f,d_t("VLUG",$i["vin_lugar3"]));
 pon($oE,"EA",$f,d_t("VQUI",$i["vin_quien4"]));
 pon($oE,"EB",$f,d_t("VFRE",$i["vin_frecuencia4"]));
 pon($oE,"EC",$f,d_t("VLUG",$i["vin_lugar4"]));
 pon($oE,"ED",$f,snb($i["vin_abrazar"]));
 pon($oE,"EE",$f,$i["vin_observaciones"]); 
};
 pon($oE,"EF",$f,un_campo("select descripcion from trim_egreso where trimestral=".$t["id"]));
 pon($oE,"EG",$f,un_campo("select estraccion from trim_estrategias where trimestral=".$t["id"]));
 pon($oE,"EH",$f,un_campo("select articulacion from trim_estrategias where trimestral=".$t["id"]));
 
 $f=$f+1;
};

 $oE->setActiveSheetIndex(1);
 pon($oE,"B",1,$anio);
 pon($oE,"A",2,"Trimestre");
 pon($oE,"B",2,$trimestre);
 pon($oE,"B",3,$_SESSION["DiaHoy"]);
 $oE->setActiveSheetIndex(0);
  for ($col = 'A'; $col <= 'Z'; $col++) { 
        $oE->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);         
        $oE->getActiveSheet()->getColumnDimension("A".$col)->setAutoSize(true);         
        $oE->getActiveSheet()->getColumnDimension("B".$col)->setAutoSize(true);         
        $oE->getActiveSheet()->getColumnDimension("C".$col)->setAutoSize(true);         
        $oE->getActiveSheet()->getColumnDimension("D".$col)->setAutoSize(true);         
  };
 // lista de no autoajustadas
  $oE->getActiveSheet()->getColumnDimension("AJ")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("AM")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("CN")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("DC")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("DJ")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("EA")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("EB")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("EC")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("ED")->setAutoSize(false);         

  $oE->getActiveSheet()->getColumnDimension("V")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("BD")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("BV")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("CT")->setAutoSize(false);         

  $filename = 'Vuelco'.$trimestre.$anio.'.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($oE);
$writer->save('php://output');
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
if(is_null($t)){$t="";};
$obj->getActiveSheet()->setCellValue($col.ltrim((string) $fil), $t);  
return true;
}

?>



           