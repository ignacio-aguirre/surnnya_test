<html lang='sp'><link rel="icon" href="imagenes/favicon.png" type="image/x-icon" />
<head><title><?php echo $_SESSION["prestacion"]?></title>
<META HTTP-EQUIV= "Content-Type"CONTENT="text/html;charset=latin-1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta name="google" content="notranslate" />
<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head><body>
<div class="container">
<div style='float:left'>
<?php if(!isset($_SESSION["usuario"])) Redirect(".");?>
<h4><img src='imagenes/logoconsejo.png'>&nbsp;&nbsp;<?php echo $_SESSION["prestacion"];?></h4>
</div>
<div style='float:right'>
Usuario:<strong><?php echo un_campo("select concat(apellido,', ',nombre) from usuarios where idusuarios=".$_SESSION["usuario"])?></strong>&nbsp;<img src='imagenes/llave.png' height='20' width='20' onclick=location.href="cambiar_password">
<?php if($_SESSION["prestacion"]!="Men&uacute;") echo "<a href='".$_SESSION["menu"]."'><img width='20' height='20' src='imagenes/menu.png'>Men&uacute;</a>&nbsp;&nbsp;"?>
<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a><br>
<?php echo un_campo("select nombre from roles where id=".$_SESSION["rol"]);?>
<br>
<var id='stat_general'></var>
</div>
<script src="js/generales.js?v=01.2"></script>
<script src="js/particulares.js?v=01.4"></script>
</div>
