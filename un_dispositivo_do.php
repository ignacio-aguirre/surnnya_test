<?php
include("Funciones.php");
session_start();
$nombre=tget("nombre");
$conveniado="0";
if(isset($_GET["conveniado"])){$conveniado="1";};
$nomina_hogares="0";
if(isset($_GET["nomina_hogares"])){$nomina_hogares="1";};

$ong=nget("ong");
$area_gubernamental=nget("area_gubernamental");
$tipo_dispositivo=nget("tipo_dispositivo");
$domicilio=tget("domicilio");
$piso_departamento=tget("piso_departamento");
$localidad=tget("localidad");
$barrio=tget("barrio");
$comuna=nget("comuna");
$cod_calle=nget("cod_calle");
$altura=nget("altura");
$geo_x=tget("geo_x");
$geo_y=tget("geo_y");
$telefonos=tget("telefonos");
$email=tget("email");
$referente=tget("referente");
$celular_referente=tget("celular_referente");
$dni_referente=nget("dni_referente");
$modalidad=nget("modalidad");
$plazas=nget("plazas");
$genero=nget("genero");
$etaria_desde=nget("etaria_desde");
$etaria_hasta=nget("etaria_hasta");
$poblacion=tget("poblacion");
$frecuencia=nget("frecuencia");
$ultimo_monitoreo=fget("ultimo_monitoreo");
$usuario_monitoreo=nget("usuario_monitoreo");
$baja=fget("baja");
$tramite_eximicion=tget("tramite_eximicion");
$id=nget("id");

if($id==0){
$id=inserte("insert into dispositivos(nombre,conveniado,ong,area_gubernamental,tipo_dispositivo,
domicilio,piso_departamento,localidad,barrio,comuna,cod_calle,altura,geo_x,geo_y,
telefonos,email,referente,celular_referente,dni_referente,modalidad,plazas,genero_poblacion,etaria_desde,etaria_hasta,
poblacion,frecuencia,ultimo_monitoreo,usuario_monitoreo,baja,nomina_hogares,tramite_eximicion) values(".$nombre.",".$conveniado.",".$ong.",".$area_gubernamental.",".$tipo_dispositivo.",".
$domicilio.",".$piso_departamento.",".$localidad.",".$barrio.",".$comuna.",".$cod_calle.",".$altura.",".$geo_x.",".$geo_y.",".
$telefonos.",".$email.",".$referente.",".$celular_referente.",".$dni_referente.",".$modalidad.",".$plazas.",".$genero.",".
$etaria_desde.",".$etaria_hasta.",".$poblacion.",".$frecuencia.",".$ultimo_monitoreo.",".$usuario_monitoreo.",".$baja.",".$nomina_hogares.",".$tramite_eximicion.")");}
else{
ejecute("update dispositivos set nombre=".$nombre.",conveniado=".$conveniado.",ong=".$ong.",area_gubernamental=".$area_gubernamental.", tipo_dispositivo=".$tipo_dispositivo.
", domicilio=".$domicilio.",piso_departamento=".$piso_departamento.",barrio=".$barrio.",comuna=".$comuna.",localidad=".$localidad. 
", cod_calle=".$cod_calle.", altura=".$altura.", geo_x=".$geo_x.", geo_y=".$geo_y.
", telefonos=".$telefonos.", email=".$email.",referente=".$referente.",celular_referente=".$celular_referente.",dni_referente=".$dni_referente.
", modalidad=".$modalidad.", plazas=".$plazas.", genero_poblacion=".$genero.", etaria_desde=".$etaria_desde.", etaria_hasta=".$etaria_hasta.
", poblacion=".$poblacion.", frecuencia=".$frecuencia.", ultimo_monitoreo=".$ultimo_monitoreo.", usuario_monitoreo=".$usuario_monitoreo.
", tramite_eximicion=".$tramite_eximicion.", baja=".$baja.", nomina_hogares=".$nomina_hogares." where dispositivos.id=".$id);};
Redirect($_SESSION["menu"]);
?>
