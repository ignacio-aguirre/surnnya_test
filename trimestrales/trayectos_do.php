<?php
include("funciones.php");
session_start();
$hogar=$_SESSION["hogar"];
$nnya=$_SESSION["nnnya_actual"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);
$id=un_campo("select id from trim_trayectos where anio=".$anio." and trimestre=".$trimestre." and legajo=".$nnya." and hogar=".$hogar);
if(!$id>0) $id=inserte("insert into trim_trayectos(anio,trimestre,legajo,hogar,trimestral) values(".$anio.",".$trimestre.",".$nnya.",".$hogar.",".$trimestral.")");
$tra_institucion=tget("tra_institucion");
$tra_tipo_actividad=nget("tra_tipo_actividad");
if($tra_tipo_actividad=="null"){$tra_tipo_actividad="0";};
$tra_actividad=tget("tra_actividad");
$tra_frecuencia=nget("tra_frecuencia");
if($tra_frecuencia=="null"){$tra_frecuencia="0";};
$tra_institucion2=tget("tra_institucion2");
$tra_tipo_actividad2=nget("tra_tipo_actividad2");
if($tra_tipo_actividad2=="null"){$tra_tipo_actividad2="0";};
$tra_actividad2=tget("tra_actividad2");
$tra_frecuencia2=nget("tra_frecuencia2");
if($tra_frecuencia2=="null"){$tra_frecuencia2="0";};
$tra_observaciones=tget("tra_observaciones");
$pae=nget("pae");
$pae_etapa=nget("pae_etapa");
$pae_referente=tget("pae_referente");
ejecute("update trim_trayectos set tra_institucion=".$tra_institucion.",
tipo_actividad=".$tra_tipo_actividad.",
tra_actividad=".$tra_actividad.",
frecuencia=".$tra_frecuencia.",
tra_institucion2=".$tra_institucion2.",
tipo_actividad2=".$tra_tipo_actividad2.",
tra_actividad2=".$tra_actividad2.",
frecuencia2=".$tra_frecuencia2.",
tra_observaciones=".$tra_observaciones.",
pae=".$pae.",
pae_etapa=".$pae_etapa.",
pae_referente=".$pae_referente.",
usuario=".$_SESSION["usuario"].",fecha=curdate(), trimestral=".$trimestral." where id=".$id);
Redirect("transicion?proximo=actividades&id=".$trimestral);
?>