<?php

include("Funciones.php");

session_start();

$id=nget("id");

$legajo=nget("legajo");

$madre=nget("madre");

$haymadre=nget("haymadre");



if($madre=="1" && $haymadre=="1"){

}

else{

ejecute("update grupos_legajos set madre=".$madre." where grupo=".$id." and grupo_legajo=".$legajo);};

Redirect("grupos2?id=".$id);

?>