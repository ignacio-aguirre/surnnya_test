<?php
 session_start();
 include("funciones.php");
 $origen=tget("origen");
 $destino=tget("destino");
 $distancia=nget("distancia");
 $id=un_campo("select id from movil_distancias where punto_1=".$origen." and punto_2=".$destino);
 if(!$id>"0"){
 	$id=un_campo("select id from movil_distancias where punto_1=".$destino." and punto_2=".$origen);
 }
 if(!$id>"0"){
 	$id=inserte("insert into movil_distancias(punto_1,punto_2,distancia) values(".$origen.",".$destino.",".$distancia.")");
 }
 else{
 	ejecute("update movil_distancias set punto_1=".$origen.", punto_2=".$destino." , distancia=".$distancia." where id=".$id);
 }

?>