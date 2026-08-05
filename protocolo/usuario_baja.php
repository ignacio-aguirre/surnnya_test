<?php 
include("funciones.php");
session_start();
tranca();
if($_SESSION["escritura"]!=1) Redirect("menu");
$id=$_GET["id"];
$r=un_registro("select * from usuarios where idusuarios=".$id);
ejecute("update usuarios set baja=curdate() where idusuarios=".$id);
?>
<html>
<head>
<title>Usuario dado de Baja</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head>

<body>

<div class="container" align="right">

<a href="menu"><img width="20" height="20" src="imagenes/menu.png">Men&uacute;</a>&nbsp;&nbsp;<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>

</div>

<div class="container" align="center">

<h1>Datos del Usuario dado de Baja</h1>

</div>

<form  id="form" class="" onsubmit="return validaciones()" action="usuarios" method="POST" enctype="multipart/form-data">
<div class="form-group">
<div class="container">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover table-condensed">
<tr class="info">
<th>Apellidos</th><th>Nombres</th><th>Email</th></tr>
<tr><td><input readonly id="apellidos" name="apellidos" size="30" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $r['apellidos'];?>"></td><td>
<input readonly id="nombres" name="nombres" size="30" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $r['nombres'];?>">
</td><td><input readonly id="email" name="email" size="50" maxlength="70" onblur="valida_mail(this.id)" value="<?php echo $r['email'];?>"></td></tr>
</table>
</div>
<input type="submit" value="Volver a Usuarios">
</div>
</div>
<script src="../bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script>
<script>

function llenadescripcion(){
valida_0("descripcion");
if(document.getElementById("descripcion").value!="") return true;
return false;
}

</script>

</body>

</html>

