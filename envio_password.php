<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Recuperar contrase&ntilde;a";
include("encabezado-index.php");
session_destroy();
?>
<script src="generales.js"></script>
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
</div>
<div class="container bg-light" align="center">
<h5>Ingres&aacute; la direcci&oacute;n de email registrado en el sistema y tu CUIL</h5>
<br>
<form class="form col-md-4" onsubmit="return valida()" method="get" action="enviarcontrasena">
<div class="form-group has-warning">
<label class="label-form" for="mail">Email</label>
<input class="form-control" name="mail" id="mail" type="email" autofocus required>
</div>
<div class="form-group has-warning">
<label class="label-form" for="cuil">CUIL</label>
<input class="form-control" name="cuil" id="cuil" size="11" onblur="salecuil(this.id)" required>
 </div>
 <p class="info">Si los datos coinciden con los registrados, se enviará la contrase&ntilde;a por mail</p>
<button class="btn btn-success">Enviar Formulario</button>
</form>
<?php include('footer.php')?>
</div>
</body>