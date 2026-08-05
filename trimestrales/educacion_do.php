<?php
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);
$id=un_campo("select id from trim_educacion where anio=".$anio." and trimestre=".$trimestre." and legajo=".$nnya." and hogar=".$hogar);
if(!$id>0) $id=inserte("insert into trim_educacion(anio,trimestre,legajo,hogar,trimestral) values(".$anio.",".$trimestre.",".$nnya.",".$hogar.",".$trimestral.")");
$edu_establecimiento=tpost("edu_establecimiento");
$edu_distrito_caba=npost("edu_distrito_caba");
$edu_municipio_pba=npost("edu_municipio_pba");
$edu_gestion=npost("edu_gestion");
$edu_tipo_establecimiento=npost("edu_tipo_establecimiento");
$edu_nivel=npost("edu_nivel");
$edu_asiste=npost("edu_asiste");
$edu_regular=npost("edu_regular");
$edu_grado=npost("edu_grado");
$edu_turno=npost("edu_turno");
$edu_apoyo=npost("edu_apoyo");
$edu_apoyo_efector=tpost("edu_apoyo_efector");
$edu_ultimo_grado=npost("edu_ultimo_grado");
$edu_ultimo_anio=npost("edu_ultimo_anio");
$edu_otras_ofertas=npost("edu_otras_ofertas");
$edu_observaciones=tpost("edu_observaciones");
ejecute("update trim_educacion set 
edu_establecimiento=".$edu_establecimiento.",
edu_distrito_caba=".$edu_distrito_caba.",
edu_municipio_pba=".$edu_municipio_pba.",
edu_gestion=".$edu_gestion.",
edu_tipo_establecimiento=".$edu_tipo_establecimiento.",
edu_nivel=".$edu_nivel.",
edu_asiste=".$edu_asiste.",
edu_regular=".$edu_regular.",
edu_grado=".$edu_grado.",
edu_turno=".$edu_turno.",
edu_apoyo=".$edu_apoyo.",
edu_apoyo_efector=".$edu_apoyo_efector.",
edu_ultimo_grado=".$edu_ultimo_grado.",
edu_ultimo_anio=".$edu_ultimo_anio.",
edu_otras_ofertas=".$edu_otras_ofertas.",
edu_observaciones=".$edu_observaciones.",
usuario=".$_SESSION["usuario"].",
fecha=curdate(), trimestral=".$trimestral." where id=".$id);
Redirect("transicion?proximo=".si($_SESSION["edad"]>=16,"trayectos","actividades")."&id=".$trimestral);
?>