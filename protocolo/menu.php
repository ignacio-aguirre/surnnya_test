<?php 
session_start();
include("funciones.php");
if($_SESSION["simple"]=="1") Redirect("casos");
tranca();
$_SESSION['titulo']="Men&uacute;";
include("encabezado-test.php")?>

<div class="container" align="center">
<h1>Men&uacute;</h1>
<div class="table-responsive" align="center">
<table class="table table-condensed">
<tr align="center" onclick="navega('casos')"><td>Casos</td></tr>
<tr  align="center" class="text-success" onclick="navega('imagenes/protocolo.pdf')"><td>Protocolo</td></tr>
<tr  align="center" class="text-success" onclick="navega('imagenes/Anexo2022.pdf')"><td>Anexo 2022 evaluaci&oacute;n integral</td></tr>
<tr  align="center" class="text-success" onclick="navega('video')"><td>Video divulgaci&oacute;n</td></tr>
<tr align="center"  class="text-success" onclick="navega('imagenes/folleto2.pdf')"><td>Folleto divulgaci&oacute;n</td></tr>
<tr align="center" onclick="navega('contrasena')"><td>Cambiar Contrase&ntilde;a</td></tr>
<?php if($_SESSION["sistema"]==1) echo "<tr align='center' onclick=navega('usuarios')><td>Usuarios</td></tr>";?>
<tr  align="center" class="text-danger" onclick="navega('salir')""><td>Salir</td></tr>
</table>
</div>
</div>
<script src="js/generales.js"></script>
</body>