<?php
include("Funciones.php");
session_start();
$legajo=nget("legajo");
$nombre=tget("nombre");
$sade_alta=tget("sade_alta");
$fecha_alta=fget("fecha_alta");
$igj=nget("igj");
$cuit=tget("cuit");
$tipo_entidad=nget("tipo_entidad");
$referente=tget("referente");
$celular_referente=tget("celular_referente");
$domicilio_legal=tget("domicilio_legal");
$piso_departamento=tget("piso_departamento");
$codigo_postal=tget("codigo_postal");
$localidad=tget("localidad");
$barrio=tget("barrio");
$comuna=nget("comuna");
$cod_calle=nget("cod_calle");
$altura=nget("altura");
$geo_x=tget("geo_x");
$geo_y=tget("geo_y");
$telefonos=tget("telefonos");
$email=tget("email");
$sade_baja=tget("sade_baja");
$baja=fget("baja");
$atencion_directa="0";
if(isset($_GET["atencion_directa"])){$atencion_directa="1";};
$necesidades_especiales="0";
if(isset($_GET["necesidades_especiales"])){$necesidades_especiales="1";};
$promocion="0";
if(isset($_GET["promocion"])){$promocion="1";};
$academicas_investigacion="0";
if(isset($_GET["academicas_investigacion"])){$academicas_investigacion="1";};
$genero="0";
if(isset($_GET["genero"])){$genero="1";};
$area_plenario=nget("area_plenario");
$conveniada="0";
if(isset($_GET["conveniada"])){$conveniada="1";};
$reparticion_convenio=tget("reparticion_convenio");
$estado=nget("estado");
$departamento=nget("departamento");
$frecuencia_fiscalizacion=nget("frecuencia_fiscalizacion");
$id=nget("id");
if($id==0){
$id=inserte("insert into hogares_ong(legajo,nombre,sade_alta,fecha_alta,igj,cuit,tipo_entidad,referente,celular_referente,
domicilio_legal,piso_departamento,localidad,barrio,comuna,codigo_postal,
cod_calle,altura,geo_x,geo_y,telefonos,email,sade_baja,baja,atencion_directa,necesidades_especiales,promocion,academicas_investigacion,genero,
area_plenario,conveniada,reparticion_convenio,estado,departamento,frecuencia_fiscalizacion) values(".
$legajo.",".$nombre.",".$sade_alta.",".$fecha_alta.",".$igj.",".$cuit.",".$tipo_entidad.",".$referente.",".$celular_referente.",".
$domicilio_legal.",".$piso_departamento.",".$localidad.",".$barrio.",".$comuna.",".
$codigo_postal.",".$cod_calle.",".$altura.",".$geo_x.",".$geo_y.",".$telefonos.",".$email.",".$sade_baja.",".$baja.",".$atencion_directa.",".$necesidades_especiales.",".$promocion.",".$academicas_investigacion.",".$genero.",".$area_plenario.",".$conveniada.",".
$reparticion_convenio.",".$estado.",".$departamento.",".$frecuencia_fiscalizacion.")");}
else{
ejecute("update hogares_ong set legajo=".$legajo.",nombre=".$nombre.",sade_alta=".$sade_alta.", fecha_alta=".$fecha_alta.", igj=".$igj.
",cuit=".$cuit.",tipo_entidad=".$tipo_entidad.",referente=".$referente.",celular_referente=".$celular_referente.
", domicilio_legal=".$domicilio_legal.",piso_departamento=".$piso_departamento.",barrio=".$barrio.",comuna=".$comuna.",codigo_postal=".$codigo_postal.
",localidad=".$localidad.", cod_calle=".$cod_calle.", altura=".$altura.", geo_x=".$geo_x.", geo_y=".$geo_y.
", telefonos=".$telefonos.", email=".$email.
",sade_baja=".$sade_baja.",baja=".$baja.",atencion_directa=".$atencion_directa.",necesidades_especiales=".$necesidades_especiales.
",promocion=".$promocion.",academicas_investigacion=".$academicas_investigacion.",genero=".$genero.", area_plenario=".$area_plenario.",conveniada=".$conveniada.",reparticion_convenio=".$reparticion_convenio.
", estado=".$estado.", departamento=".$departamento.", frecuencia_fiscalizacion=".$frecuencia_fiscalizacion." where id=".$id);};
Redirect('ongs');
?>
