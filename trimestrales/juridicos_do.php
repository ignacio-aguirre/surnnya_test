<?php
include("funciones.php");
session_start();
$hogar=$_SESSION["hogar"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$nnya=$_SESSION["nnnya_actual"];
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);
$id=un_campo("select id from trim_juridicos where hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio." and legajo=".$nnya);
if(!$id>0) $id=inserte("insert into trim_juridicos(hogar,trimestre,anio,legajo,trimestral) values(".$hogar.",".$trimestre.",".$anio.",".$nnya.", trimestral=".$trimestral.")");
$defensoria_zonal=nget("defensoria_zonal");
$zp_detalle=tget("zp_detalle");
$zonal_provincial=nget("zonal_provincial");
$juzgado_civil=nget("juzgado_civil");
$juzgado_otro=nget("juzgado_otro");
$juzgado_otro_q=tget("juzgado_otro_q");
$defensoria_nacional=nget("defensoria_nacional");
$defensor=tget("defensor");
$tutoria=nget("tutoria");
$tutor=tget("tutor");
$abogado_ninio=nget("abogado_ninio");
$abogado=tget("abogado");
$pertenencia=nget("pertenencia");
$ad_decretada=nget("ad_decretada");
$guardas_fallidas=nget("guardas_fallidas");
$guardas_fult_vinculacion=fget("guardas_fult_vinculacion");
$medida_excepcional=nget("medida_excepcional");
$medida_cautelar=nget("medida_cautelar");

ejecute("update trim_juridicos set
defensoria_zonal=".$defensoria_zonal.", 
zonal_provincial=".$zonal_provincial.", 
zp_detalle=".$zp_detalle.", 
juzgado_civil=".$juzgado_civil.", 
juzgado_otro=".$juzgado_otro.", 
juzgado_otro_q=".$juzgado_otro_q.", 
defensoria_nacional=".$defensoria_nacional.", 
defensor=".$defensor.", 
tutoria=".$tutoria.", 
tutor=".$tutor.", 
abogado_ninio=".$abogado_ninio.", 
abogado=".$abogado.", 
pertenencia=".$pertenencia.", 
ad_decretada=".$ad_decretada.", 
guardas_fallidas=".$guardas_fallidas.", 
guardas_fult_vinculacion=".$guardas_fult_vinculacion.",
medida_excepcional=".$medida_excepcional.",
medida_cautelar=".$medida_cautelar.",
usuario=".$_SESSION["usuario"].", fecha=curdate(), trimestral=".$trimestral." where id=".$id);
Redirect("transicion?proximo=ingreso&id=".$trimestral);
?>