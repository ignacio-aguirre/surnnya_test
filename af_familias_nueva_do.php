<?php
require("Funciones.php");
session_start();
$hogar=nget("hogar");
$denominacion=tget("denominacion");
$estado1=nget("estado1");
$fecha_disposicion=fget("fecha_disposicion");
$registro_unico=nget("registro_unico");
$anio=nget("anio");
if($estado1=="1"){$fecha_estado1=$fecha_disposicion;}else{$fecha_estado1="curdate()";};
$id=inserte("insert into af_familias(hogar,denominacion,estado1,fecha_estado1,fecha_disposicion,registro_unico,anio) values(".$hogar.",".$denominacion.",".$estado1.",".$fecha_estado1.",".$fecha_disposicion.",".$registro_unico.",".$anio.")");
inserte("insert into af_familias_estados(familia,estado1,fecha,usuario) values(".$id.",".$estado1.",".$fecha_estado1.",".tsql($_SESSION["glusua"]).")");
$tipodoc=nget("tipodoc");
$nrodoc=nget("nrodoc");
$apellidos=tget("apellidos");
$nombres=tget("nombres");
$idpersona=un_campo("select idpersonas from personas where tipodoc=".$tipodoc." and nrodoc=".$nrodoc." limit 1");
if(!$idpersona>"0"){$idpersona=inserte("insert into personas(apellidos,nombres,tipodoc,nrodoc,familia_pertenencia,vinculo,conviviente) values(".$apellidos.",".$nombres.",".$tipodoc.",".$nrodoc.",".$id.",1,1)");};
ejecute("update af_familias set persona=".$idpersona." where idaf_familias=".$id);
$fecha_nacimiento=fget("fecha_nacimiento");
$edad=nget("edad");
$nacionalidad=nget("nacionalidad");
$genero=tget("genero");
$estadocivil=nget("estadocivil");
$caba=nget("caba");
$barrio=tget("barrio");
$comuna=nget("comuna");
$localidad=tget("localidad");
$calle_nro=tget("calle");
$otros_domicilio=tget("otras");
$partido=tget("partido");
$email=tget("email");
$telefonos=tget("telefonos");
$ocupacion=tget("ocupacion");
$fecha_actualizacion=fget("fecha_actualizacion");
ejecute("update personas set apellidos=".$apellidos.
", nombres=".$nombres.
", fecha_nacimiento=".$fecha_nacimiento.
", edad=".$edad.
", nacionalidad=".$nacionalidad.
", genero=".$genero.
", estadocivil=".$estadocivil.
", caba=".$caba.
", barrio=".$barrio.
", comuna=".$comuna.
", localidad=".$localidad.
", callenro=".$calle_nro.
", otros_domicilio=".$otros_domicilio.
", partido=".$partido.
", email=".$email.
", telefonos=".$telefonos.
", ocupacion=".$ocupacion.
", fecha_actualizacion=".$fecha_actualizacion.
" where idpersonas=".$idpersona);
Redirect("consultafamilias");
?>