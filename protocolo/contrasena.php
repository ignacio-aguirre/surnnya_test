<?php 
include("funciones.php");
session_start();
tranca();
?>
<html>
<head>
<title>Cambiar Contrase&ntilde;a de Acceso al Sistema</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container" align="right">
<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>
</div>
<div class="container" align="center">
<h1>Cambiar Contrase&ntilde;a de Acceso al Sistema</h1>
</div>
<div class="container">
<div class="row" align="center">
<div class="col-md-12">
Su Contrase&ntilde;a Actual:
</div>
<div class="col-md-12">
<input class="input" id="actual" type="password" size="15" maxlength="15"></div>
</div>
</div>
<br>
<div class="row" align="center">
<div class="col-md-12">
Su Nueva Contrase&ntilde;a:
</div>
<br>
<div class="col-md-12">
<input class="input" id="nueva" type="password" size="15" maxlength="15"></div>
</div>
<div class="col-md-6">
La nueva contraseña deberá contener al menos una letra y un n&uacute;mero y su longitud deberá ser mayor o igual a 6 caracteres
</div>

<br>
<div class="row" align="center">
<div class="col-md-12">
Repetir Nueva Contrase&ntilde;a:
</div>

<div class="col-md-12">
<input class="input" id="repeticion" type="password" size="15" maxlength="15"></div>
</div>
</div>

<br>
<div class="row" align="center">
<div class="col-md-12">
<button class="btn btn-primary" onclick="script:procesa()">Ingresar</button>
</div>
</div>

</div>
<script src="../bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script>
<script>document.getElementById("actual").focus();

function procesa(){
actual=document.getElementById("actual").value;
nueva=document.getElementById("nueva").value;
repeticion=document.getElementById("repeticion").value;

if(actual!=""&&nueva!=""&&repeticion!=""){
    if(nueva.length<6){ alert("Contraseña tiene menos de 6 caracteres"); return false;};
    if(nueva.indexOf("0")==-1 && nueva.indexOf("1")==-1 && nueva.indexOf("2")==-1 && nueva.indexOf("3")==-1 && nueva.indexOf("4")==-1 && nueva.indexOf("5")==-1 && nueva.indexOf("6")==-1 && nueva.indexOf("7")==-1 && nueva.indexOf("8")==-1 && nueva.indexOf("9")==-1)
     {alert("Contraseña no contiene números"); return false;};
    if(!tieneletras(nueva)) {alert("Contraseña no contiene letras"); return false;};

    if(nueva!=repeticion) {alert("Contraseña no coincide con Repetición"); return false;};
    url="control_password?actual="+actual;
    pet = new XMLHttpRequest();
    pet.open('GET', url, false);
    pet.send(null);
    var resp = pet.responseText;
    if(resp==0) {alert("Contraseña Actual es Incorrecta"); return false;};
    navega("cpassword?id=<?php echo $_SESSION['usuario']?>&pass="+nueva+"&salir=1");
};
}

function tieneletras(x){
for(i=0;i<x.length;i++) {
 d=x.slice(i,i+1);
 if("a"<=d & d<="z") return true;
};
return false;
};
</script>

</body>