<?php

include("Funciones.php");

session_start();

$id=nget("id");

$apellidos="";

$haymadre="0";

$reg=registros("select apellidos, madre from grupos_legajos left join sujetos on grupo_legajo=legajo where grupo=".$id);



while($r=mysqli_fetch_assoc($reg)){



$posi=strpos($apellidos,$r["apellidos"]);



if(is_bool($posi)) {$apellidos=$apellidos.si($apellidos=="",""," ").$r["apellidos"];};

if($r["madre"]=="1") {$haymadre="1";};

};

$numero=un_campo("select count(*) from grupos where idgrupos<>".$id." and apellidos=".tsql($apellidos));

$numero=$numero+1;

if($numero>1) $apellidos=$apellidos." ".$numero; 

echo $haymadre.substr($apellidos,0,199);?>