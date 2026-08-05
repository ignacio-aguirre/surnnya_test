<?php
include("Funciones.php");
session_start();
$id=nget("id");
if(!$id>0) Redirect("ongs");
$_SESSION["prestacion"]="Eliminar ONG ".un_campo("select nombre from hogares_ong where id=".$id);
include("encabezado.php");
$cantidad=un_campo("select count(*) from dispositivos where ong=".$id);
if($cantidad>0) {die("No se puede eliminar esta ONG porque tiene hogares asociados");};
ejecute("update hogares_ong set baja=curdate() where id=".$id);
Redirect("ongs");
?>
