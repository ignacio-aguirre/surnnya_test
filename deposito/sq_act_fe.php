<?php
 include("funciones.php");
 session_start();
 $id=nget('id');
 $ficha_estante=tget('ficha_estante');
 ejecute("update unidades set ficha_estante=".$ficha_estante." where id=".$id);
?>