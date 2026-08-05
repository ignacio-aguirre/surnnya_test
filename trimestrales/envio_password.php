<?php
session_start();
session_destroy();
?>
<script src="js/nuevos.js"></script>
<head><title>Enviador de Password</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="icon" href="imagenes/favicon.png" type="image/x-icon" />
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css"></head><body>
<div class="container">
<h2>Ingres&aacute; el mail registrado en Supervisi&oacute;n y tu DNI</h2>
<form class="form" method="get" action="enviarcontrasena">
<label class="label-form" for="mail">Mail</label>
<input class="form-control" type="text" name="mail" id="mail" autofocus required onblur="valida_mail(this.id)">
<label class="label-form" for="dni">DNI</label>
<input class="form-control" type="text" name="dni" id="dni" size="8" required onblur="valida_entero(this.id)">
<input type="submit" value="Enviar">
</form>
</body>