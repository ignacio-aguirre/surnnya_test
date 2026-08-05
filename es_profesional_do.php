<?php
session_start();
include("Funciones.php");
$id=nget("id");
$nombre=tget("nombre");
$apellido=tget("apellido");
$profesion=nget("profesion");
$matricula=tget("matricula");
$alta=fget("alta");
$baja=fget("baja");
$usuario=nget("usuario");
if($id=="0"){
$id=inserte("insert into es_profesionales(apellido,nombre,profesion,matricula,alta,baja,usuario) values(".$apellido.",".$nombre.",".$profesion.",".$matricula.
",".$alta.",".$baja.",".$usuario.")");}
else{
 ejecute("update es_profesionales set apellido=".$apellido.", nombre=".$nombre.", profesion=".$profesion.", matricula=".$matricula.", alta=".$alta.
", baja=".$baja.", usuario=".$usuario." where id=".$id);
};
Redirect("es_profesionales");
?>