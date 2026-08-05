<?php
session_start();
session_destroy();
session_start();
include("static/par-conexion.php");
include("funciones.php");
$_SESSION['DiaHoy']=ffec(un_campo("select curdate() as hoy"));
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">'
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
<link rel="shortcut icon" href="https://www.buenosaires.gob.ar/sites/gcaba/files/favicon.png" type="image/png" />
<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
<title>Trimestrales</title>
</head>
<body background="imagenes/pibe.jpg">
<script src="js/nuevos.js"></script>
<script>
function valida(){
navega("validaingreso?user="+document.getElementById("user").value+"&password="+document.getElementById("password").value);
}

</script>
<div class="container" align="center">
<h1 style="color:white">TRIMESTRALES</h1>
<br>
<h2 style="color:white">Acced&eacute; al Sistema con tu usuario y contrase&ntilde;a registrados</h2>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4" style="color:white">Usuario <input class="form-control" id="user" name="user" size="45" maxlength="45" autofocus></div>
</div>
<br>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4" style="color:white">Contrase&ntilde;a <input class="form-control" id="password" name="password" type="password" size="15" maxlength="15"></div>
</div>
<br>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4"><button class="btn btn-primary" onclick="script:valida()">Ingresar</button></div>
</div>
<br>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4"><button class="btn btn-info" onclick="navega('envio_password')">Enviarme contrase&ntilde;a por mail</button></div>
</div>
<div class="row">
<div class="col-md-4"></div>
<!--div class="col-md-4"><button class="btn btn-success" onclick="navega('/moviles/indexdispo')">Móviles</button></div-->
</div>
<br>
</div>
</body>
</html>