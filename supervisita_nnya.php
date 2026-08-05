<?php
include("Funciones.php");
session_start();
$id=nget("id");
$lega=nget("legajo");
$texto=tget("texto");
$idvl=un_campo("select idsuper_visita_legajo from super_visita_legajo where super_visita=".$id." and super_legajo=".$lega);
if($idvl=="") {$idvl=inserte("insert into super_visita_legajo(super_visita,super_legajo) values(".$id.",".$lega.")");};
ejecute("update super_visita_legajo set super_obse=".$texto." where idsuper_visita_legajo=".$idvl);
exit;
?>
