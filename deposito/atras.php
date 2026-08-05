<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Aviso";
include("encabezado.php");
$t=$_GET["t"];
?>
<div class="container">
<h4><?php echo $t;?></h4>
Presiona ((atr&aacute;s)) para continuar
<hr>
</div>
</body>