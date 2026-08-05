<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Nueva Familia";
include("encabezado.php");
noconsulta();
$localidades = $_SESSION['loc_caba'];
?>
</div>
<div class="container">

<form class="form-inline" method="post" onsubmit='return valida()' action="fv_familia_nueva_do">
 <div class="form-group has-warning">
  <label class="label-form" for="descripcion">Descripci&oacute;n</label>
  <input class="form-control" required maxlength="200" size="100" id="descripcion" name="descripcion" required>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="legajomanual">Legajo</label>
  <input class="form-control" maxlength="6" size="6" id="legajomanual" name="legajomanual" onblur="valida_legajo(this.id)" required>
 </div>
 <br><br>
 <div class="form-group has-warning">
  <label class="label-form" for="localidad">Localidad</label>
  <select class="form-control" id="localidad" name="localidad"><?php echo $localidades?></select>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="domicilio">Domicilio</label>
  <input class="form-control" id="domicilio" name="domicilio" required size="60" maxlength="60">
 </div>
 <br><br>
 <input class="btn btn-primary" type="submit" value="Crear y Pasar a Miembros">
</form>
</div>
<script type="text/javascript">
function valida_legajo(id){
 valida_entero(id);
 valor=document.getElementById(id).value;
 if(parseInt(valor)==0||valor==""){alert("el numero de legajo debe ser positivo");return false;};
 return true;
}
function valida(){
  if(!valida_legajo("legajomanual")){return false;};
  return true;
}
</script>
</body>
</html>