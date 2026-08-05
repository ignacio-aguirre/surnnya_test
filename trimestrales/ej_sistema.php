<?php

include('funciones.php');

session_start();

$tipo=$_GET['tipo'];


if($tipo=="PASSWORD"){

 $id=$_SESSION['usuario'];

 echo strtoupper(un_campo("select password from usuarios_hogares where id=".$id));

};



if($tipo=="PASSWORD_CAMBIA"){
 $id=$_SESSION['usuario'];
 $nueva=tget('nueva');
 ejecute("update usuarios_hogares set password=".$nueva." where id=".$id);

};



if($tipo=="LEER_NOTIFICACION"){

 $id=$_GET['notificacion'];

 ejecute("update notificaciones set leido=1 where idnotificaciones=".$id);

};


if($tipo=='TABLA_VALOR'){
$id=nget("id");
$tipot=tget("tipot");
$valor=nget("valor");
echo un_campo("select case when idtablas_semestrales>0 then 1 else 0 end from tablas_semestrales where tipo=".$tipot." and valor=".$valor." and baja is null and idtablas_semestrales<>".$id);
};


if($tipo=='FIRMAR'){
 $id=nget("id");
 ejecute("update semestral set firma=".$_SESSION["firma"]." where idsemestral=".$id);
 echo $id;
};

?>