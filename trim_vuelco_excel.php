<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include("Funciones.php");
session_start();
$anio=nget("anio");
$trimestre=nget("trimestre");
$ut=nget("ut");

$ruta="trimestrales/importacion/PlantillaVAnual.xlsx";
$oE = IOFactory::load($ruta);

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
if(!is_null($i)){  
 pon($oE,"A",$f,$t["nombre"]);
 pon($oE,"B",$f,$trimestre);
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
};

 $i=un_registro("select * from trim_juridicos where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"W",$f,d_ts("CM",$i["defensoria_zonal"]));
 pon($oE,"X",$f,d_t("ZP",$i["zona_provincial"]));
 pon($oE,"Y",$f,$i["zp_detalle"]);
 pon($oE,"Z",$f,snb($i["medida_excepcional"]));
 pon($oE,"AA",$f,snb($i["medida_cautelar"]));
 pon($oE,"AB",$f,$i["juzgado_civil"]);
 pon($oE,"AC",$f,d_t("TJ",$i["juzgado_otro"]));
 pon($oE,"AD",$f,$i["juzgado_otro_q"]);
 pon($oE,"AE",$f,d_n($i["defensoria_nacional"],"Vacio"));
 pon($oE,"AF",$f,$i["defensor"]);
 pon($oE,"AG",$f,d_n($i["tutoria"],"Vacio"));
 pon($oE,"AH",$f,$i["tutor"]);
 pon($oE,"AI",$f,snb($i["abogado_ninio"]));
 pon($oE,"AJ",$f,$i["abogado"]);
 pon($oE,"AK",$f,d_t("ANP",$i["pertenencia"]));
 pon($oE,"AL",$f,snb($i["ad_decretada"]));
 pon($oE,"AM",$f,snb($i["guardas_fallidas"]));
 pon($oE,"AN",$f,ffec($i["guardas_fult_vinculacion"]));
 };
 pon($oE,"AO",$f,un_campo("select descripcion from trim_ingreso where trimestral=".$t["id"]));
 pon($oE,"AP",$f,un_campo("select descripcion from trim_convivencial where trimestral=".$t["id"]));

 $i=un_registro("select * from trim_salud_fisica where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"AQ",$f,snb($i["obra_social"]));
 pon($oE,"AR",$f,snb($i["en_tratamiento"]));
 pon($oE,"AS",$f,si($i["juris_ef1"]<"1","",d_t(si($i["juris_ef1"]=="1","ESAC","ESAB"),$i["ef_1"])));
 pon($oE,"AT",$f,si($i["juris_ef2"]<"1","",d_t(si($i["juris_ef2"]=="1","ESAC","ESAB"),$i["ef_2"])));
 pon($oE,"AU",$f,si($i["juris_ef3"]<"1","",d_t(si($i["juris_ef3"]=="1","ESAC","ESAB"),$i["ef_3"])));
 pon($oE,"AV",$f,d_t("ESPEC",$i["especialidad_1"]));
 pon($oE,"AW",$f,d_t("ESPEC",$i["especialidad_2"]));
 pon($oE,"AX",$f,d_t("ESPEC",$i["especialidad_3"]));
 pon($oE,"AY",$f,d_t("ESPEC",$i["especialidad_4"]));
 pon($oE,"AZ",$f,si($i["juris_odonto"]<"1","",d_t(si($i["juris_odonto"]=="1","ESAC","ESAB"),$i["ef_odonto"])));
 pon($oE,"BA",$f,$i["obse_odonto"]);
 pon($oE,"BB",$f,snb($i["calendario_vacunacion"]));
 pon($oE,"BC",$f,snb($i["internacion"]));
 pon($oE,"BD",$f,snb($i["plan_medicacion"]));
 pon($oE,"BE",$f,snb($i["plan_detalle"]));
 pon($oE,"BF",$f,$i["sf_observaciones"]);
 };

 $i=un_registro("select * from trim_salud_mental where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"BG",$f,snb($i["en_tratamiento"]));
 pon($oE,"BH",$f,si($i["juris_em1"]<"1","",d_t(si($i["juris_em1"]=="1","ESMEN","ESAB"),$i["em_1"])));
 pon($oE,"BI",$f,$i["pm_1"]);
 pon($oE,"BJ",$f,si($i["juris_em2"]<"1","",d_t(si($i["juris_em2"]=="1","ESMEN","ESAB"),$i["em_2"])));
 pon($oE,"BK",$f,$i["pm_2"]);
 pon($oE,"BL",$f,si($i["juris_em3"]<"1","",d_t(si($i["juris_em3"]=="1","ESMEN","ESAB"),$i["em_3"])));
 pon($oE,"BM",$f,$i["pm_3"]);
 pon($oE,"BN",$f,si($i["juris_em4"]<"1","",d_t(si($i["juris_em4"]=="1","ESMEN","ESAB"),$i["em_4"])));
 pon($oE,"BO",$f,$i["pm_4"]);
 pon($oE,"BP",$f,d_t("ESPSM",$i["espec_sm1"]));
 pon($oE,"BQ",$f,d_t("ESPSM",$i["espec_sm2"]));
 pon($oE,"BR",$f,d_t("ESPSM",$i["espec_sm3"]));
 pon($oE,"BS",$f,d_t("ESPSM",$i["espec_sm4"]));
 pon($oE,"BT",$f,snb($i["plan_medicacion"]));
 pon($oE,"BU",$f,$i["plan_detalle"]);
 if($i["plan_efector"]=="1") pon($oE,"BV",$f,$i["pm_1"]);
 if($i["plan_efector"]=="2") pon($oE,"BV",$f,$i["pm_2"]);
 if($i["plan_efector"]=="3") pon($oE,"BV",$f,$i["pm_3"]);
 if($i["plan_efector"]=="4") pon($oE,"BV",$f,$i["pm_4"]);
 pon($oE,"BW",$f,snb($i["sm_internacion"]));
 pon($oE,"BX",$f,$i["sm_observaciones"]);
 pon($oE,"BY",$f,si($i["at_tuvo"]=="1","Si",""));
 pon($oE,"BZ",$f,d_t("ATPSM",$i["at_prestador"]));
 pon($oE,"CA",$f,$i["at_esquema"]);
 };
 $i=un_registro("select * from trim_discapacidad where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"CB",$f,d_t("DIS_TIPO",$i["tipo_discapacidad"]));
 pon($oE,"CC",$f,snb($i["certificado_discapacidad"]));
 pon($oE,"CD",$f,ffec($i["cd_vencimiento"]));
 pon($oE,"CE",$f,$i["cd_diagnostico"]);
 pon($oE,"CF",$f,$i["cd_prestaciones"]);
 pon($oE,"CG",$f,si($i["pension"]=="1","Si",si($i["pension"]=="2","No",si($i["pension"]=="3","En tramite",""))));
 pon($oE,"CH",$f,d_t("DIS_PET",$i["pension_estado_tramite"]));
 pon($oE,"CI",$f,snb($i["incluir_salud"]));
};
$i=un_registro("select * from trim_educacion where trimestral=".$t["id"]);
if(!is_null($i)){
 pon($oE,"CJ",$f,snb($i["edu_asiste"]));
 pon($oE,"CK",$f,$i["edu_establecimiento"]);
 pon($oE,"CL",$f,$i["edu_distrito_caba"]);
 pon($oE,"CM",$f,d_t("EMUNI",$i["edu_municipio_pba"]));
 if($i["edu_gestion"]=="1") {pon($oE,"CN",$f,"Estatal");};
 if($i["edu_gestion"]=="2") {pon($oE,"CN",$f,"Privada");};
 if($i["edu_gestion"]=="3") {pon($oE,"CN",$f,"Mixta");};
 pon($oE,"CO",$f,d_t("ETIPO",$i["edu_tipo_establecimiento"]));
 pon($oE,"CP",$f,d_t("ENIVE",$i["edu_nivel"]));
 pon($oE,"CQ",$f,snb($i["edu_asiste"]));
 pon($oE,"CR",$f,snb($i["edu_regular"]));
 pon($oE,"CS",$f,d_t("EGRAD",$i["edu_grado"]));
 pon($oE,"CT",$f,d_t("ETURN",$i["edu_turno"]));
 pon($oE,"CU",$f,snb($i["edu_apoyo"]));
 pon($oE,"CV",$f,$i["edu_apoyo_efector"]);
 pon($oE,"CW",$f,d_t("EGRAD",$i["edu_ultimo_grado"]));
 pon($oE,"CX",$f,$i["edu_ultimo_anio"]);
 pon($oE,"CY",$f,d_t("EOOFE",$i["edu_otras_ofertas"]));
 pon($oE,"CZ",$f,$i["edu_observaciones"]);
};
 $i=un_registro("select * from trim_trayectos where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"DA",$f,d_t("TAFL",$i["tipo_actividad"]));
 pon($oE,"DB",$f,$i["tra_institucion"]);
 pon($oE,"DC",$f,$i["tra_actividad"]);
 pon($oE,"DD",$f,d_t("AFRE",$i["frecuencia"]));
 pon($oE,"DE",$f,d_t("TAFL",$i["tipo_actividad2"]));
 pon($oE,"DF",$f,$i["tra_institucion2"]);
 pon($oE,"DG",$f,$i["tra_actividad2"]);
 pon($oE,"DH",$f,d_t("AFRE",$i["frecuencia2"]));
 pon($oE,"DI",$f,$i["tra_observaciones"]);
 pon($oE,"DJ",$f,$i["pae"]);
 pon($oE,"DK",$f,$i["pae_etapa"]);
 pon($oE,"DL",$f,$i["pae_referente"]);
};
 $i=un_registro("select * from trim_actividades where trimestral=".$t["id"]);
 if(!is_null($i)){
 pon($oE,"DM",$f,d_t("TADRC",$i["tipo_actividad"]));
 pon($oE,"DN",$f,$i["institucion"]);
 pon($oE,"DO",$f,$i["actividad"]);
 pon($oE,"DP",$f,d_t("AFRE",$i["frecuencia"]));
 pon($oE,"DQ",$f,d_t("TADRC",$i["tipo_actividad2"]));
 pon($oE,"DR",$f,$i["institucion2"]);
 pon($oE,"DS",$f,$i["actividad2"]);
 pon($oE,"DT",$f,d_t("AFRE",$i["frecuencia2"]));
 pon($oE,"DU",$f,$i["observaciones"]);
};
$i=un_registro("select * from trim_vinculaciones where trimestral=".$t["id"]);
if(!is_null($i)){
 pon($oE,"EA",$f,snb($i["vin_tuvo"]));
 pon($oE,"EB",$f,d_t("VQUI",$i["vin_quien"]));
 pon($oE,"EC",$f,d_t("VFRE",$i["vin_frecuencia"]));
 pon($oE,"ED",$f,d_t("VLUG",$i["vin_lugar"]));
 pon($oE,"EE",$f,d_t("VQUI",$i["vin_quien2"]));
 pon($oE,"EF",$f,d_t("VFRE",$i["vin_frecuencia2"]));
 pon($oE,"EG",$f,d_t("VLUG",$i["vin_lugar2"]));
 pon($oE,"EH",$f,d_t("VQUI",$i["vin_quien3"]));
 pon($oE,"EI",$f,d_t("VFRE",$i["vin_frecuencia3"]));
 pon($oE,"EJ",$f,d_t("VLUG",$i["vin_lugar3"]));
 pon($oE,"EK",$f,d_t("VQUI",$i["vin_quien4"]));
 pon($oE,"EL",$f,d_t("VFRE",$i["vin_frecuencia4"]));
 pon($oE,"EM",$f,d_t("VLUG",$i["vin_lugar4"]));
 pon($oE,"EN",$f,snb($i["vin_abrazar"]));
 pon($oE,"EO",$f,$i["vin_observaciones"]); 
 };
 pon($oE,"EP",$f,un_campo("select descripcion from trim_egreso where trimestral=".$t["id"]));
 pon($oE,"EQ",$f,un_campo("select estraccion from trim_estrategias where trimestral=".$t["id"]));
 pon($oE,"ER",$f,un_campo("select articulacion from trim_estrategias where trimestral=".$t["id"]));


 
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
        $oE->getActiveSheet()->getColumnDimension("E".$col)->setAutoSize(true);         
  }; 
 // lista de no autoajustadas
  $oE->getActiveSheet()->getColumnDimension("AO")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("AP")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("BD")->setAutoSize(false);          
  $oE->getActiveSheet()->getColumnDimension("BE")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("BF")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("BT")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("BU")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("BX")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("CA")->setAutoSize(false); 
  $oE->getActiveSheet()->getColumnDimension("CE")->setAutoSize(false); 
  $oE->getActiveSheet()->getColumnDimension("CF")->setAutoSize(false); 
  $oE->getActiveSheet()->getColumnDimension("CK")->setAutoSize(false); 
      
  $oE->getActiveSheet()->getColumnDimension("CZ")->setAutoSize(false);
  $oE->getActiveSheet()->getColumnDimension("DF")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("DG")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("DL")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("DP")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("DU")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("EO")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("EP")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("EQ")->setAutoSize(false);         
  $oE->getActiveSheet()->getColumnDimension("ER")->setAutoSize(false);         

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



           