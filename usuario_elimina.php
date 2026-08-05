<?php
include("Funciones.php");
session_start();
if(!isset($_GET["vusuario"])) Redirect(".");
$id=$_GET["vusuario"];
$apyn=un_campo("select concat(apellido,', ',nombre) from usuarios where id=".$id);
$_SESSION["prestacion"]="Eliminaci&oacute;n de Usuario ".$apyn;
include("encabezado-test.php");

?>
</div>
<div class="container">
<p class="text-warning">Est&aacute;s seguro/a? Si no, presiona ATRAS para volver</p>
<hr>
<button class="btn-danger" onclick="navega('usuario_elimina_do?id=<?php echo $id?>')">S&iacute;, Eliminar</button>
</div>
</body>