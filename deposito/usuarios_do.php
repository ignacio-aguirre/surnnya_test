<?php
include("funciones.php");
session_start();
$id=nget("id");
$apellido=tget("apellido");
$nombre=tget("nombre");
$cuil=tget("cuil");
$email=tget("email");
$rol=nget("rol");
$password=tsql(rand(13786,98437));
$exis1=un_campo("select idusuarios from usuarios where apellido=".$apellido." and nombre=".$nombre." and idusuarios<>".$id);
if($exis1>"0"){ Redirect("atras?t=Usuario existente nombre y apellido");};
$exis2=un_campo("select idusuarios from usuarios where cuil=".$cuil." and idusuarios<>".$id);
if($exis2>"0"){ Redirect("atras?t=Usuario existente cuil");};
$exis3=un_campo("select idusuarios from usuarios where email=".$email." and idusuarios<>".$id);
if($exis3>"0"){ Redirect("atras?t=Usuario existente email");};
if($id=="0"){
  $id=inserte("insert into usuarios(apellido,nombre,cuil,email,password,rol) values(".$apellido.",".$nombre.",".$cuil.",".$email.",".$password.",".$rol.")");
  Redirect("aviso?tipo=USUARIO&id=".$id."&acc=creado");
}
else{
  ejecute("update usuarios set apellido=".$apellido.", nombre=".$nombre.", cuil=".$cuil.", email=".$email.", rol=".$rol.
  " where idusuarios=".$id);
  Redirect("aviso?tipo=USUARIO&id=".$id."&acc=modificado");

};
?>