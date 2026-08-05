<?php 
include("funciones.php");
session_start();
$_SESSION["titulo"]="Subir nuevo documento";
tranca();
include("encabezado-test.php");
$id=$_SESSION["caso"];
$nya=un_campo("select concat(apellidos,', ',nombres) from casos where idcasos=".$id)?>
<div class="container" align="center">
	<h4>Subir documento a caso <?php echo $nya?></h4>
</div>		
<div class="container">
<section class="col-md-12">
<form class="form" action="uploadarch" onsubmit="return llenadescripcion()" method="POST" enctype="multipart/form-data">
<div class="form-group has-warning col-md-2">
<label for="fecha_archivo">Fecha del documento:</label>
<input class="form-control" id="fecha_archivo" name="fecha_archivo"  size="8" maxlength="10" onblur="valida_fecha(this.id)">
</div>
<div class="form-group has-warning col-md-6">
<label for="descripcion">Descripci&oacute;n:</label>
<input class="form-control" id="descripcion" name="descripcion">
</div>
<div class="form-group has-warning col-md-4">
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
<div class="form-group has-warning col-md-6">
<input type="file" id="archivo" name="archivo">
&nbsp;<p class="help-block">Maximo 50MB</p>
</div>
<div class="form-group has-warning">
<input type="hidden" name="id" value="<?php echo $id;?>">
<button class="btn-sm btn-primary" name="action">Subir Archivo</button>
</div>
</form>
</section>
<script>
function llenadescripcion(){
if(chequea_estado()){
valida_0("descripcion");
valida_fecha("fecha_archivo");
if(document.getElementById("descripcion").value!="") return true;
};
return false;
}
</script>