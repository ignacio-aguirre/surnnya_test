<?php
 session_start();
 include("funciones.php");
 $origen=tget("origen");
 $destino=tget("destino");
 
 $id=un_campo("select id from movil_distancias where punto_1=".$origen." and punto_2=".$destino);
 if(!$id>"0"){
 	$id=un_campo("select id from movil_distancias where punto_1=".$destino." and punto_2=".$origen);
 }
 $dist="0";
 if($id>"0"){
 	$dist=un_campo("select distancia from  movil_distancias where id=".$id);
 };
 echo $dist;
?>