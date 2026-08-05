<?php 
include("funciones.php");
session_start();
$_SESSION["titulo"]="Registrar nueva acci&oacute;n";
tranca();
include("encabezado-test.php");
$id=$_SESSION["caso"];
$nya=un_campo("select concat(apellidos,', ',nombres) from casos where idcasos=".$id)?>
<div class="container" align="center">
	<h4>Registrar nueva acci&oacute;n caso <?php echo $nya?></h4>
</div>		
<div class="container">
<section class="col-md-12">
<form  class="form" action="uploadnove" onsubmit="return llenanovedad()" method="POST" enctype="multipart/form-data">
<div class="form-group col-md-2">
<label for="fecha">Fecha:</label>
<input autocomplete="false" class="form-control" id="fecha" name="fecha" size="8" maxlength="10" onblur="valida_fecha(this.id)">
</div>
<div class="form-group col-md-10">
<label for="novedad">Descripci&oacuten:</label>
<textarea automplete="false" class="form-control" id="novedad" name="novedad" rows="3" cols="120"></textarea>
</div>
<div class="form-group col-md-8">
<input type="hidden" name="iid" value="<?php echo $id;?>">
<label class="label-form">Origen</label>
<select class="form-control" name="origen">
	<option value="1">Cdnnya</option>
	<option value="2">Dispo C. Alt.</option>
	<option value="3">Justicia penal</option>
	<option value="4">Justicia civil</option>
	<option value="5">PSAdicciones</option>
	<option value="6">Salud</option>
</select>
</div>
<button class="btn-sm btn-primary" name="action">Registrar Acci&oacuten</button>
</form>
</section>
<script>
function llenadescripcion(){
if(chequea_estado()){
valida_0("descripcion");
valida_fecha("fecha");
if(document.getElementById("descripcion").value!="") return true;
};
return false;
}
function llenanovedad(){
valida_0("novedad");
if(document.getElementById("novedad").value=="") {alert("complete texto de novedad");return false;};
if(document.getElementById("fecha").value=="") {alert("complete fecha de novedad");return false;};
return true;

}
</script>