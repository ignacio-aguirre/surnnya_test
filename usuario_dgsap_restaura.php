<?php
include("Funciones.php");
session_start();
$cuil=tget("cuil");
ejecute("update usuarios set baja=null, estado='ACTIVO' where cuil=".$cuil);
$id=un_campo("select id from usuarios where cuil=".$cuil);
$apyn=un_campo("select concat(apellido,', ',nombre) from usuarios where cuil=".$cuil);
$texto="Usuario restaurado ".$apyn;
registro_rapido($texto);

Redirect("unusuario_dgsap?vusuario=".$id);
?>