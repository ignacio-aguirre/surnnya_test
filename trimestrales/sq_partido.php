<?php
include("funciones.php");
session_start();
if(!$_SESSION["hogar"]>"0"){Redirect(".");};
if(isset($_GET["loca"])){
 $loca=tget("loca");
 $part=un_campo("select partido from localidades_nueva where nombre=".$loca);
}
else{$part="";};
echo $part;
?>