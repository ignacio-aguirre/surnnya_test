<?php
include("funciones.php");
session_start();
$id=nget("id");
$descripcion=tget("descripcion");
$rubro=nget("rubro");
$tipo=nget("tipo_bien");
$vence=nget("vencimiento");
if($id=="0"){
  $id=inserte("insert into articulos(descripcion,rubro,tipo_bien,vencimiento) values(".$descripcion.",".$rubro.",".$tipo.",".$vence.")");
  Redirect("aviso?tipo=ARTICULO&id=".$id."&acc=creado");
}
else{
  ejecute("update articulos set descripcion=".$descripcion.", rubro=".$rubro.", tipo_bien=".$tipo.", vencimiento=".$vence." where idarticulos=".$id);
  Redirect("aviso?tipo=ARTICULO&id=".$id."&acc=modificado");

};
?>