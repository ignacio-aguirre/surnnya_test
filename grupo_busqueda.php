<?php

include("Funciones.php");

session_start();

$tipo=$_GET["tipo"];

$cat=" categoria=".$tipo;

if($tipo=="1") $cat=" categoria<>2";

$reg=registros("select idgrupos, apellidos from grupos where ".$cat." order by apellidos"); 

$o="";

while($r=mysqli_fetch_assoc($reg)){

 $o=$o."<option value='".$r["idgrupos"]."'>".$r["apellidos"]."</option>";

};

echo $o;

?>