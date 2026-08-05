<?php
session_start();
include("static/par-conexion.php");
include("funciones.php");
$_SESSION['DiaHoy']=ffec(un_campo("select curdate() as hoy"));
$_SESSION["login"]="1";
include("encabezado-test.php");
?>

<script>
function valida(){
navega("validaingreso?user="+document.getElementById("user").value+"&password="+document.getElementById("password").value);
}
function resetear(){
	navega("resetearpassword?user="+document.getElementById("user").value);
}	
</script>

<div class="container" align="center">
<h1>Ingreso al Sistema de Datos Compartidos</h1>
</div>
<div class="container">
<div class="row" align="center">
<div class="col-md-12">
Ingres&aacute; el mail con el que te est&aacute;s registrado/a vos o tu grupo de trabajo en el Sistema
</div>
<br><br>
<div class="col-md-12">
<input class="input" id="user" name="user" size="50" maxlength="60"> 
</div>
</div>
<br>
<div class="row" align="center">
<div class="col-md-12">
Ingres&aacute; tu Contrase&ntilde;a
</div>
</div>
<div class="row" align="center">
<br>
<div class="col-md-12">
<input class="input" id="password" name="password" type="password" size="15" maxlength="15"> 
</div>
</div>
<br>
<div class="row" align="center">
<div class="col-md-12">
<button class="btn btn-primary" onclick="script:valida()">Ingresar</button><br><br>
<button class="btn btn-primary" onclick="script:resetear()">Olvid&eacute; mi contrase&ntilde;a</button>
</div>
</div>
<br>
<p class="text-info">
Si olvidaste tu contrase&ntilde;a o no pod&eacute;s ingresar con la que usabas habitualmente, complet&aacute; arriba el campo de mail y luego presion&aacute; el bot&oacute;n "Olvid&eacute; mi contrase&ntilde;a"
</p>
</div>
<script>document.getElementById("user").focus();</script>
<script src="../bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script>
</body>
</html>