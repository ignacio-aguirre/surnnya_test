<?php 
include("funciones.php");
session_start();
tranca();
if($_SESSION["escritura"]!=1) Redirect("menu");
$id=$_GET["id"];
$r=un_registro("select * from usuarios where idusuarios=".$id);
?>
<html>
<head>
<title>Carga de datos de un Usuario</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head>
<script>
function validaciones(){

if(document.getElementById("apellidos").value=="") {alert("debe completar apellidos");return false};

if(document.getElementById("nombres").value=="") {alert("debe completar nombres");return false};

if(document.getElementById("email").value=="") {alert("debe completar email");return false};
if(document.getElementById("reparticion").value=="") {alert("debe completar organismo");return false};
if(document.getElementById("sector").value=="") {alert("debe completar sector");return false};

return true;

}

</script>

<body>

<div class="container" align="right">

<a href="menu"><img width="20" height="20" src="imagenes/menu.png">Men&uacute;</a>&nbsp;&nbsp;<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>

</div>

<div class="container" align="center">

<h1>Datos del nuevo Usuario</h1>

</div>

<form  id="form" class="" onsubmit="return validaciones()" action="grabausuario" method="POST" enctype="multipart/form-data">

<div class="form-group">

<div class="container">

<div class="table-responsive">

<table class="table table-striped table-bordered table-hover table-condensed">

<tr class="info">

<th>Apellidos</th><th>Nombres</th><th>Email</th></tr>

<tr><td><input id="apellidos" name="apellidos" size="30" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $r['apellidos'];?>"></td><td>
<input id="nombres" name="nombres" size="30" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $r['nombres'];?>">

</td><td><input id="email" name="email" size="50" maxlength="70" onblur="valida_mail(this.id)" value="<?php echo $r['email'];?>"></td></tr>


</table>

</div>

<div class="table-responsive">

<table class="table table-striped table-bordered table-hover table-condensed">

<tr class="info">

<th>Organismo</th><th>Sector</th><th>Grupal</th><th>Carga</th><th>Sistema</th>

</tr>
<tr><td><input id="reparticion" name="reparticion" size="15" maxlength="15" onblur="valida_0(this.id)" value="<?php echo $r['reparticion'];?>">
</td><td><input id="sector" name="sector" size="15" maxlength="15" onblur="valida_0(this.id)" value="<?php echo $r['sector'];?>"></td>
<td><input id="grupal" name="grupal" size="1" maxlength="1" onblur="valida_entero(this.id)" value="<?php echo $r['grupal'];?>"></td>
<td><input id="carga" name="carga" size="1" maxlength="1" onblur="valida_entero(this.id)" value="<?php echo $r['supervisa_sector'];?>"></td>
<td><input id="sistema" name="sistema" size="1" maxlength="1" onblur="valida_entero(this.id)" value="<?php echo $r['supervisa_sistema'];?>"></td>
</tr>

</table>
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="submit" value="Enviar Datos">
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

function llenanovedad(){

valida_0("novedad");

if(document.getElementById("novedad").value!="") return true;

return false;

}

if('<?php echo $_SESSION["escritura"]?>'=="0"){

  document.getElementById("novedad").disabled=true;

  document.getElementById("descripcion").disabled=true;

  document.getElementById("archivo").disabled=true;

}; 

</script>

</body>

</html>

