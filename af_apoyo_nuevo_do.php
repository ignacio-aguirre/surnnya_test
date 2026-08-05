<?php
require("Funciones.php");
session_start();
$alojamiento=nget("alojamiento");
$familia=nget("familia");
$f_desde=fget("f_desde");
inserte("insert into af_apoyos(alojamiento,familia,f_desde) values(".$alojamiento.",".$familia.",".$f_desde.")");
Redirect("af_apoyos?id=".$alojamiento);
?>