<?php
include("funciones.php"); 
session_start();
$t=tget("t");
echo un_campo("select case when id>0 and lat_google<0 and lon_google<0 then concat(lat_google,';',lon_google) 
	else '' end from domicilios where direccion=".$t);
exit();
?>