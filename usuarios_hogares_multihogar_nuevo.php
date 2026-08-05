<?php
include("Funciones.php");
session_start();
$usuario=nget("id");
$hogar=nget("hogar");
$funcion=tget("funcion");
if($usuario>"0" && $hogar>"0"){
 $id_roles=un_campo("select id from usuarios_hogares_roles where usuario=".$usuario." and hogar=".$hogar);
 if(!$id_roles>"0"){$id_roles=inserte("insert into usuarios_hogares_roles(usuario,hogar,funcion) values(".$usuario.",".$hogar.",".$funcion.")");}
 else{ejecute("update usuarios_hogares_roles set funcion=".$funcion." where id=".$id_roles);};
 if($funcion=="''"){ejecute("delete from usuarios_hogares_roles where id=".$id_roles);};
 Redirect("usuarios_hogares_multihogar?id=".$usuario);
};
?>