<?php
 include("funciones.php");
 session_start();
 $u=$_SESSION["usuario"];
 $articulo=nget('articulo');
 $cantidad=nget('cantidad');
 $fe=tget('fe');

 $stock=un_campo('select cantidad from existencias where articulo='. $articulo);
 if(intval($cantidad)==0) $cantidad="0";
 if(intval($stock)+intval($cantidad)<0) {$cantidad="0";};
 ejecute("update temporal_pedidos set cantidad=".$cantidad." where usuario=".$u." and articulo=".$articulo." and ficha_estante=".$fe);
 echo $cantidad;

?>