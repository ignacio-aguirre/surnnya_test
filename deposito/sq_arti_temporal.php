<?php
 include("funciones.php");
 session_start();
 $comprobante=nget('comprobante');
 $renglon=nget('renglon');
 $siguelargo="0";
 if(isset($_GET["siguelargo"])){$siguelargo="1";};
 $cantidad=$_GET['cantidad'];

 $articulo=un_campo("select articulo from pedidos_articulos where comprobante=".$comprobante." and renglon=".$renglon);

 $disp=un_campo('select cantidad-autorizado from existencias where articulo='. $articulo." and deposito=".$_SESSION["deposito"]);

 if(intval($cantidad)==0) $cantidad="0";

 if(intval($cantidad)>intval($disp) & $siguelargo=="0") {$cantidad=(string)intval($disp);};

 ejecute("update pedidos_articulos set temporal=".$cantidad." where comprobante=".$comprobante." and articulo=".$articulo);

 echo $cantidad;

?>