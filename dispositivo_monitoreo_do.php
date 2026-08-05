<?php
session_start();
include("Funciones.php");
$id=nget("id");
$ultimo_monitoreo=fget("ultimo_monitoreo");
ejecute("update dispositivos set ultimo_monitoreo=".$ultimo_monitoreo." where id=".$id);
Redirect("dispositivos");
?>