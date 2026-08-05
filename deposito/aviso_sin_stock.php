<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Aviso";
include("encabezado.php");
$lista=$_GET["lista"];?>
<div class="container">
<h5>No se pudo cerrar remito</h5>
<h6><?php echo $lista;?></h4>
Presiona <a href='remitos_consulta'>aqu&iacute;</a> para continuar
</div>
</body>