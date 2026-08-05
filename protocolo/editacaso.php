<?php 
include("funciones.php");
session_start();
tranca();
if($_SESSION["escritura"]!=1) Redirect("menu");
$id=$_SESSION["caso"];
$r=un_registro("select *, edadcalc(fecha_nacimiento,edad,fecha_edad,null) as edc from casos where idcasos=".$id);
?>
<html lang="ES">
<head>
<title>Modificaci&oacuten de Datos</title>
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
valida_entero("juzgado");
valida_0("expediente");
valida_0("defensor");
valida_0("cdnnya");
valida_0("intervencion_sj");
return true;
}

</script>

<body>

<div class="container" align="right">

<a href="menu"><img width="20" height="20" src="imagenes/menu.png">Men&uacute;</a>&nbsp;&nbsp;<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>

</div>

<div class="container" align="center">

<h1>Datos del Caso</h1>

</div>

<form  id="form" class="" onsubmit="return validaciones()" action="grabacaso" method="POST" enctype="multipart/form-data">

<div class="form-group">

<div class="container">

<div class="table-responsive">

<table class="table table-striped table-bordered table-hover table-condensed">

<tr class="info">

<th>Apellidos</th><th>Nombres</th><th>F.Nacimiento</th><th>Edad(*)</th><th>Fecha Edad(**)</th></tr>

<tr><td><input id="apellidos" name="apellidos" size="30" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $r["apellidos"];?>"></td><td><input id="nombres" name="nombres" size="30" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $r["nombres"];?>">

</td><td><input id="fecha_nacimiento" name="fecha_nacimiento" size="10" maxlength="10" onblur="valida_fecha(this.id,1)" value="<?php echo ffec($r["fecha_nacimiento"]);?>"></td><td>

<input id="edad" name="edad" size="2" maxlength="2" onblur="valida_entero(this.id)" value="<?php echo $r["edad"];?>"></td><td><input id="fecha_edad" name="fecha_edad" size="10" maxlength="10" onblur="valida_fecha(this.id,1)" value="<?php echo ffec($r["fecha_edad"]);?>"></td></tr>

</table>

</div>

<div class="table-responsive">

<table class="table table-striped table-bordered table-condensed">

<tr class="info">

<th>Tipo (***)</th><th>Nro.Documento</th><th>Nacionalidad</th><th>Juzgado Civil</th><th>Expediente</th>

</tr>

<tr><td><input id="tipo_documento" name="tipo_documento" size="3" maxlength="3" onblur="valida_0(this.id)" value="<?php echo $r["tipo_documento"];?>"></td><td>

<input id="numero_documento" name="numero_documento" size="10" maxlength="10" onblur="valida_entero(this.id)" value="<?php echo $r["numero_documento"];?>">
<td><input id="nacionalidad" name="nacionalidad" size="40" maxlength="50" onblur="valida_0(this.id)" value="<?php echo $r["nacionalidad"];?>"></td>
<td><input id="juzgado" name="juzgado" size="3" maxlength="3" onblur="valida_entero(this.id)" value="<?php echo $r["juzgado"];?>"></td>
<td><input id="expediente" name="expediente" size="12" maxlength="25" onblur="valida_0(this.id)" value="<?php echo $r["expediente"];?>"></td></tr>
</table>
</div>
<div class="table-responsive">

<table class="table table-striped table-bordered table-condensed">

<tr class="info">

<th>Defensor</th><th>Equipo/DZ CDNNYA</th><th>Intervenci&oacuten Socio Jur&iacute;dica JNM</th>

</tr>
<tr><td><input id="defensor" name="defensor" size="40" maxlength="60" onblur="valida_0(this.id)" value="<?php echo $r["defensor"];?>"></td>
<td><input id="cdnnya" name="cdnnya" size="40" maxlength="60" onblur="valida_0(this.id)" value="<?php echo $r["cdnnya"];?>"></td>
<td><input id="intervencion_sj" name="intervencion_sj" size="40" maxlength="60" onblur="valida_0(this.id)" value="<?php echo $r["intervencion_sj"];?>"></td></tr>
</tr>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<tr class="info"><th>TOM Nro.</th><th>Sugerencia de Hospital</th>
<tr><td><select id="tom" name="tom">
<option value="0"></option>
<option value="1">TOM 1</option>
<option value="2">TOM 2</option>
<option value="3">TOM 3</option>
</select></td>
<?php 
$hospitales="";
$hos=registros("select * from hospitales where baja is null order by descripcion");
while($h=mysqli_fetch_assoc($hos)){
$hospitales=$hospitales."<option value='".$h["idhospitales"]."'>".$h["descripcion"]."</option>";
};
?>
<td><select id="hospital" name="hospital"><?php echo $hospitales?></select></td></tr>
</table>
</div>


(*)  Completar el campo edad solamente cuando no se tiene la fecha de nacimiento, con la edad que el NN/A declara<br>

(**) Completar el campo Fecha edad solamente cuando se completa el campo edad, indicando la fecha en que se consult&oacute al NN/A la misma.<br>

(***)Completar el campo con el texto DNI o CI o PAS, estos &uacuteltimos para c&eacutedula o pasaporte extranjeros.<br>
(****) Completar el campo n&uacutemero de documento si y solo si se indica el tipo<br>
Los campos Apellidos, Nombres, Tipo Documento y Nacionalidad son obligatorios. Use S/D si no se tiene el dato.<br><br>

<input type="hidden" name="id" value="<?php echo $id;?>">

<input type="submit" value="Enviar Datos">

</div>
<script>seleccionar("tom","<?php echo $r['tom']?>");

function seleccionar(x,valor) {
var y=document.getElementById(x).options;
var cosa=document.getElementById(x);
for (i=0;i<y.length;i++)
{
if(y[i].value==valor) cosa.selectedIndex=i}; 
};
</script>


</div>













<script src="../bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script>
<script>
document.getElementById("hospital").value="<?php echo $r['hospital_sugerido']?>";
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

