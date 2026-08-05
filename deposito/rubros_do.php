<?php
include("funciones.php");
session_start();
$id=nget("id");
$descripcion=tget("descripcion");
if($id=="0"){
  $id=inserte("insert into articulos_rubros(descripcion) values(".$descripcion.")");
  Redirect("aviso?tipo=RUBRO&id=".$id."&acc=creado");
}
else{
  ejecute("update articulos_rubros set descripcion=".$descripcion." where idarticulos_rubros=".$id);
  Redirect("aviso?tipo=RUBRO&id=".$id."&acc=modificado");
};
?>