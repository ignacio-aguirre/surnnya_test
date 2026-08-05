<?php 
include("Funciones.php");
session_start();
$id=$_GET["id"];
$hogar=$_GET["hogar"];
$apellidos=tget("apellidos");
$nombres=tget("nombres");
$dni=nget("dni");
$profesion=tget("profesion");
$matricula=tget("matricula");
$email=tget("email");
$firma=si($_GET["firma"]=="on","1","0");
$es_trimestrales="1";

$perfil_moviles=nget("perfil_moviles");
$descripcion=tget("descripcion");
$es_multihogar=si($_GET["es_multihogar"]=="on","1","0");

ejecute("update usuarios_hogares set apellidos=".$apellidos.",nombres=".$nombres.", dni=".$dni.", profesion=".$profesion.", matricula=".$matricula." where id=".$id);
ejecute("update usuarios_hogares set email=".$email.",es_trimestrales=".$es_trimestrales.",firma=".$firma.", descripcion=".$descripcion.", es_multihogar=".$es_multihogar.", perfil_moviles=".$perfil_moviles." where id=".$id);
if($es_multihogar=="1"){
  ejecute("update usuarios_hogares set funcion=null, hogar=0 where id=".$id);
  Redirect("usuarios_hogares_multihogar?id=".$id);
 } 
else{
  Redirect("usuarios_hogares_hogar?id=".$id."&hogar=".$hogar);
}
?>
