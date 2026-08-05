<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Aviso";
include("encabezado.php");
$tipo=$_GET["tipo"];
$id=$_GET["id"];
$acc=$_GET["acc"];
$url="mnu_dp";
if($tipo=="ARTICULO"){$url="articulos";};
if($tipo=="RUBRO"){$url="rubros";};
if($tipo=="EFECTOR"){$url="efectores";};
if($tipo=="USUARIO"){$url="usuarios";};
?>
<div class="container">
<h4><?php echo $tipo." ".$id." ".$acc;?></h4>
Presiona <a href='<?php echo $url?>'>aqu&iacute;</a> para continuar
<hr>
</div>
</body>