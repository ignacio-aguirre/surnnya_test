<?php
session_start();
include("funciones.php");
$id=nget("id");
$nlabo=nget("l");
  ejecute("update fechas set laborable=".$nlabo." where id=".$id);

Redirect("mv_fechas");
?>