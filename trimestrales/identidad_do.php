<?php
include("funciones.php");
session_start();
$hogar=$_SESSION["hogar"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$nnya=$_SESSION["nnnya_actual"];
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);
$id=un_campo("select id from trim_identidad where hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio." and legajo=".$nnya);
if(!$id>0) $id=inserte("insert into trim_identidad(hogar,trimestre,anio,legajo,trimestral) values(".$hogar.",".$trimestre.",".$anio.",".$nnya.",".$trimestral.")");
$otros_nombres=tpost("otros_nombres");
$pais_nacimiento=npost("pais_nacimiento");
$provincia_nacimiento=npost("provincia_nacimiento");
$pais_ultresfam=npost("pais_ultresfam");
$localidad_ultresfam=tpost("localidad_ultresfam");
$provincia_ultresfam=tpost("provincia_ultresfam");
$partido_ultresfam=tpost("partido_ultresfam");
$barrio_ultresfam=tpost("barrio_ultresfam");
$pais_origenfam=npost("pais_origenfam");
$provincia_origenfam=npost("provincia_origenfam");
$partida=npost("partida");
$partida_ubicacion=npost("partida_ubicacion");
$documento_posee=npost("documento_posee");
$documento_tipo=npost("documento_tipo");
$documento_numero=tpost("documento_numero");
$documento_ubicacion=npost("documento_ubicacion");
$informacion_familiar=tpost("informacion_familiar");
$identidad_genero=npost("identidad_genero");
ejecute("update trim_identidad set
otros_nombres=".$otros_nombres.",
 pais_nacimiento=".$pais_nacimiento.",
provincia_nacimiento=".$provincia_nacimiento.",
pais_ultresfam=".$pais_ultresfam.",
localidad_ultresfam=".$localidad_ultresfam.",
provincia_ultresfam=".$provincia_ultresfam.",
partido_ultresfam=".$partido_ultresfam.",
barrio_ultresfam=".$barrio_ultresfam.",
pais_origenfam=".$pais_origenfam.",
provincia_origenfam=".$provincia_origenfam.",
partida=".$partida.",
partida_ubicacion=".$partida_ubicacion.",
documento_posee=".$documento_posee.",
documento_tipo=".$documento_tipo.",
documento_numero=".$documento_numero.",
documento_ubicacion=".$documento_ubicacion.",
identidad_genero=".$identidad_genero.",
informacion_familiar=".$informacion_familiar.",
usuario=".si(isset($_SESSION["usuario"]),$_SESSION["usuario"],0).", fecha=curdate(), trimestral=".$trimestral." where id=".$id);
Redirect("transicion?proximo=juridicos&id=".$trimestral);
?>