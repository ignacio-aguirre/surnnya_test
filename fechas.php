<?php

session_start();

include("Funciones.php");

$fecha=$_GET["primera"];

$diasem=un_campo("select date_format('".$fecha."','%w')");

if($diasem=="0") $diasem="7";



$fec=$fecha;

while(substr($fec,4,2)==substr($fecha,4,2)){

 $ulfe=$fec; 

 $fec=fsql(ffec(un_campo("select date_add('".$fec."', INTERVAL 1 DAY) from dual")));

};

echo $diasem.substr($ulfe,6,2);

?>