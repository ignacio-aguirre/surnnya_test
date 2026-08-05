<?php 
include("Funciones.php"); 
session_start();
if(isset($_SESSION["gl_sesion"])){
if($_SESSION["gl_sesion"]>"0"){registros("delete from sesiones where idsesiones=".$_SESSION["gl_sesion"]);};
};
include("encabezado-index.php");
session_destroy();
$mensaje="";
if(isset($_GET["mensaje"])) $mensaje=$_GET["mensaje"];
?>
</div>
<div class="container" style="background-color: #ECFEFF;" align="center">
	<br><br>
<p class="col-md-6">Se ha cerrado la sesi&oacute;n de SURNNYA</p>
<br>
<p class="col-md-6"><?php echo $mensaje?></p>
<br>
<p class="col-md-6">Para volver a SURNNYA clic <a href=".">Aqu&iacute;</a></p>
<br><br>
</div>
<script>
function miTimer(){
ocurre=ocurre-1;
if(ocurre<1) navega("about:blank");
};
var ocurre=100;

var myVar=setInterval(function(){miTimer()},1000);
</script>

</body>
</html>