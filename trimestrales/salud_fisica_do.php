<?php
include("funciones.php");
session_start();
$hogar=$_SESSION["hogar"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$nnya=$_SESSION["nnnya_actual"];
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);

$id=un_campo("select id from trim_salud_fisica where hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio." and legajo=".$nnya);
if(!$id>0) $id=inserte("insert into trim_salud_fisica(hogar,trimestre,anio,legajo,trimestral) values(".$hogar.",".$trimestre.",".$anio.",".$nnya.",".$trimestral.")");
$cobertura_portenia="0";
$obra_social=npost("obra_social");
$en_tratamiento=npost("en_tratamiento"); 
$ef_1=npost("ef_1");
$ef_2=npost("ef_2");
$ef_3=npost("ef_3");
$ef_odonto=npost("ef_odonto");
$juris_ef1=npost("juris_ef1");
$juris_ef2=npost("juris_ef2");
$juris_ef3=npost("juris_ef3");
$juris_odonto=npost("juris_odonto");
$especialidad_1=npost("especialidad_1");
$especialidad_2=npost("especialidad_2");
$especialidad_3=npost("especialidad_3");
$especialidad_4=npost("especialidad_4");
$obse_odonto=tpost("obse_odonto");
$calendario_vacunacion=npost("calendario_vacunacion");
$internacion=npost("internacion");
$plan_medicacion=npost("plan_medicacion");
$plan_detalle=tpost("plan_detalle");
$sf_observaciones=tpost("sf_observaciones");
ejecute("update trim_salud_fisica set
obra_social=".$obra_social.", 
en_tratamiento=".$en_tratamiento.", 
ef_1=".$ef_1.", 
ef_2=".$ef_2.", 
ef_3=".$ef_3.", 
ef_odonto=".$ef_odonto.", 
juris_ef1=".$juris_ef1.",
juris_ef2=".$juris_ef2.",
juris_ef3=".$juris_ef3.",
juris_odonto=".$juris_odonto.",
especialidad_1=".$especialidad_1.", 
especialidad_2=".$especialidad_2.", 
especialidad_3=".$especialidad_3.", 
especialidad_4=".$especialidad_4.", 
obse_odonto=".$obse_odonto.",
calendario_vacunacion=".$calendario_vacunacion.", 
internacion=".$internacion.", 
plan_medicacion=".$plan_medicacion.", 
plan_detalle=".$plan_detalle.", 
sf_observaciones=".$sf_observaciones.",
usuario=".$_SESSION["usuario"].", fecha=curdate(),trimestral=".$trimestral." where id=".$id);
Redirect("transicion?proximo=salud_mental&id=".$trimestral);
?>