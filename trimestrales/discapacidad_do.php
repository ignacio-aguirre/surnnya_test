<?php
include("funciones.php");
session_start();
$hogar=$_SESSION["hogar"];
$nnya=$_SESSION["nnnya_actual"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);

$id=un_campo("select id from trim_discapacidad where hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio." and legajo=".$nnya);
if(!$id>0) $id=inserte("insert into trim_discapacidad(hogar,trimestre,anio,legajo,trimestral) values(".$hogar.",".$trimestre.",".$anio.",".$nnya.",".$trimestral.")");
$certificado_discapacidad=nget("certificado_discapacidad");
$cd_vencimiento=fget("cd_vencimiento");
$cd_diagnostico=tget("cd_diagnostico");
$cd_prestaciones=tget("cd_prestaciones");
$tipo_discapacidad=nget("tipo_discapacidad");
$pension=nget("pension");
$pension_estado_tramite=nget("pension_estado_tramite");
$incluir_salud=nget("incluir_salud");
ejecute("update trim_discapacidad set
certificado_discapacidad=".$certificado_discapacidad.", 
cd_vencimiento=".$cd_vencimiento.", 
cd_diagnostico=".$cd_diagnostico.", 
cd_prestaciones=".$cd_prestaciones.", 
tipo_discapacidad=".$tipo_discapacidad.", 
pension=".$pension.", 
pension_estado_tramite=".$pension_estado_tramite.", 
incluir_salud=".$incluir_salud.", 
usuario=".$_SESSION["usuario"].", fecha=curdate(),trimestral=".$trimestral." where id=".$id);
Redirect("transicion?proximo=educacion&id=".$trimestral);

?>