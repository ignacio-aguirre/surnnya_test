<?php

include('funciones.php');

session_start();

$tipo=$_GET['tipo'];


if($tipo=="PASSWORD"){
 $id=$_SESSION['usuario'];
 echo un_campo("select password from usuarios where idusuarios=".$id);
};



if($tipo=="PASSWORD_CAMBIA"){
 $id=$_SESSION['usuario'];
 $nueva=tget('nueva');
 ejecute("update usuarios set password=".$nueva." where idusuarios=".$id);
};

?>