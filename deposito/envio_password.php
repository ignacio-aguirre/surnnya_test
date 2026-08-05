<?php
session_start();
session_destroy();
?>
<script src="js/generales.js"></script>
<script>
function salecuil(id){
if(!validaCuit(document.getElementById(id).value)) document.getElementById(id).value="";
}
function valida(){
if(document.getElementById("mail").value=="") return false;
if(document.getElementById("cuil").value=="") return false;
return true;
}
</script>

<head><title>Enviador de Password</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="icon" href="imagenes/favicon.png" type="image/x-icon" />
<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css"></head><body>
<div class="container">
<h2>Ingres&aacute; el mail registrado en este sistema y tu CUIL</h2>
<form class="form" onsubmit="return valida()" method="get" action="enviarcontrasena">
<label class="label-form" for="mail">Mail</label>
<input class="form-control" type="text" name="mail" id="mail" onblur="valida_mail(this.id)">
<label class="label-form" for="cuil">CUIL</label>
<input class="form-control" type="text" name="cuil" id="cuil" size="11" onblur="salecuil(this.id)">
<input type="submit" value="Enviar">
</form>
</body>