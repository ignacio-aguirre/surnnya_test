<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
$legajo=un_campo("select legajo from pae_supervisiones where idpae_supervisiones=".$id);
$archivo=un_campo("select archivo from pae_supervisiones where idpae_supervisiones=".$id);
ejecute("delete from pae_supervisiones where idpae_supervisiones=".$id);
if($archivo>"0"){ejecute("delete from archivos_vinculos where archivo=".$archivo." and identificador=".$legajo);};
Redirect("pae_supervisiones?legajo=".$legajo);
?>