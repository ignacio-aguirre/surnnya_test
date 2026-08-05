<?php
include("funciones.php");
session_start();
$id=nget("id");
$descripcion=tget("descripcion");
$domicilio=tget("domicilio");
$localidad=tget("localidad");
$barrio=tget("barrio");
$comuna=nget("comuna");
$telefonos=tget("telefonos");

if($id=="0"){
  $dispositivo=nget("dispositivo");
  $id=inserte("insert into efectores(descripcion,domicilio,localidad,barrio,comuna,telefonos,dispositivo) values(".$descripcion.",".
$domicilio.",".$localidad.",".$barrio.",".$comuna.",".$telefonos.",".$dispositivo.")");
  Redirect("aviso?tipo=EFECTOR&id=".$id."&acc=creado");
}
else{
  ejecute("update efectores set descripcion=".$descripcion.",domicilio=".$domicilio.", localidad=".$localidad.",barrio=".$barrio.", comuna=".$comuna.
", telefonos=".$telefonos." where idefectores=".$id);
  Redirect("aviso?tipo=EFECTOR&id=".$id."&acc=modificado");
};
?>