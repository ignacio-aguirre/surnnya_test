<?php 
include("funciones.php");
session_start();
tranca();

if($_SESSION["escritura"]!=1) Redirect("menu");
$_SESSION["caso"]=0;
?>

<html>
<head>
<title>Carga de datos de un nuevo Caso</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head>
<script>

function validaciones(){

if(document.getElementById("apellidos").value=="") {alert("debe completar apellidos");return false};

if(document.getElementById("nombres").value=="") {alert("debe completar nombres");return false};

if(document.getElementById("edad").value!="" && document.getElementById("fecha_edad").value=="" ) {alert("indique fecha de referencia de la edad");return false};
if(document.getElementById("nacionalidad").value=="") {alert("debe completar nacionalidad");return false;};
if(document.getElementById("tipo_documento").value!="DNI" && document.getElementById("tipo_documento").value!="CI" && document.getElementById("tipo_documento").value!="PAS" && document.getElementById("tipo_documento").value!="S/D") {alert("tipo documento incorrecto");return false;}; 
if(document.getElementById("tipo_documento").value!="S/D"  &&  document.getElementById("numero_documento").value=="") {alert("indique el número de documento si completa el tipo");return false;};
if(document.getElementById("tipo_documento").value=="S/D"  &&  document.getElementById("numero_documento").value!="") {alert("indique el tipo de documento si completa el número");return false;};

return true;

}

</script>

<body>

<div class="container" align="right">

<a href="menu"><img width="20" height="20" src="imagenes/menu.png">Men&uacute;</a>&nbsp;&nbsp;<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>

</div>

<div class="container" align="center">

<h1>Datos del nuevo Caso</h1>

</div>

<form  id="form" class="" onsubmit="return validaciones()" action="grabacaso" method="POST" enctype="multipart/form-data">

<div class="form-group">

<div class="container">

<div class="table-responsive">

<table class="table table-striped table-bordered table-hover table-condensed">

<tr class="info">

<th>Apellidos</th><th>Nombres</th><th>F.Nacimiento</th><th>Edad(*)</th><th>Fecha Edad(**)</th></tr>

<tr><td><input id="apellidos" name="apellidos" size="30" maxlength="45" onblur="valida_0(this.id)"></td><td><input id="nombres" name="nombres" size="30" maxlength="45" onblur="valida_0(this.id)">

</td><td><input id="fecha_nacimiento" name="fecha_nacimiento" size="10" maxlength="10" onblur="valida_fecha(this.id,1)"></td><td>

<input id="edad" name="edad" size="2" maxlength="2" onblur="valida_entero(this.id)"></td><td><input id="fecha_edad" name="fecha_edad" size="10" maxlength="10" onblur="valida_fecha(this.id,1)"></td></tr>

</table>

</div>

<div class="table-responsive">

<table class="table table-striped table-bordered table-hover table-condensed">

<tr class="info">

<th>Tipo(***)</th><th>Nro.Documento</th><th>Nacionalidad</th>

</tr>

<tr><td><input id="tipo_documento" name="tipo_documento" size="3" maxlength="3" onblur="valida_0(this.id)"></td><td>

<input id="numero_documento" name="numero_documento" size="10" maxlength="10" onblur="valida_entero(this.id)"></td>
<td><input id="nacionalidad" name="nacionalidad" size="40" maxlength="50" onblur="valida_0(this.id)"></td></tr>

</table>

(*)  Completar el campo edad solamente cuando no se tiene la fecha de nacimiento, con la edad que el NN/A declara<br>

(**) Completar el campo Fecha edad solamente cuando se completa el campo edad, indicando la fecha en que se consult&oacute al NN/A la misma.<br>

(***)Completar el campo con el texto DNI o CI o PAS, estos &uacuteltimos para c&eacutedula o pasaporte extranjeros.<br>

(****) Completar el campo n&uacutemero de documento si y solo si se indica el tipo<br>
Los campos Apellidos, Nombres, Tipo Documento y Nacionalidad son obligatorios. Use S/D si no se tiene el dato.<br><br>
<input type="hidden" name="id" value="0">

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

