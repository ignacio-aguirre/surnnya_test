<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Men&uacute; administrador viajes DGSAP";
include("encabezado.php");
?>
</div>
<br><br>
<div class="container">

<ul class="list-group-item">Opciones disponibles
<li class="list-item" onclick="navega('menu_fechas')"> Fechas </li>
<li class="list-item" onclick="navega('mv_dispositivos')"> Dispositivos </li>
<li class="list-item" onclick="navega('mv_sectores')"> Sectores </li>
<li class="list-item" onclick="navega('mv_usuarios')"> Usuarios disp. conveniados </li>
<li class="list-item" onclick="navega('mv_domicilio_nuevo')">Nuevo Domicilio</li>
<li class="list-item" onclick="navega('mv_version_cambios')"> Ver cambios en &uacute;ltima versi&oacute;n (<?php echo $_SESSION["version"]?>) </li>
</ul>
</div>
</html>

