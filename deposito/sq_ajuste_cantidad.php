<?php
 include("funciones.php");
 session_start();
 $sid=tsql(session_id());
 $articulo=nget('articulo');
 $cantidad=nget('cantidad');
 
 $stock=un_campo('select cantidad from existencias where articulo='. $articulo);
 if(intval($cantidad)==0) $cantidad="0";
 if(intval($stock)+intval($cantidad)<0) {$cantidad="0";};
 ejecute("update temporal_ajustes set cantidad=".$cantidad." where sesion=".$sid." and articulo=".$articulo);
 echo $cantidad;

?>