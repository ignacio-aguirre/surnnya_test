<?php 
include("funciones.php");
session_start();
if(!$_SESSION["hogar"]>"0"){Redirect(".");};
$_SESSION["prestacion"]="Registrar nueva localidad";
include("encabezado.php");
$pais=nget("pais");
$prov=$_GET["provincia"];
$part=$_GET["partido"];
?>
</div>
<div class="container">

<form class="form" action="nlocalidad_do" method="post" >
	<div class="form-group has-warning">
	  <label class="label-form">Pa&iacute;s</label>
	<input  hidden name="pais" value="<?php echo $pais?>">
        <p class="text-info"><?php echo un_campo("select descripcion from paises where idpaises=".$pais)?></p>
	</div>
	<div class="form-group has-warning">
	  <label class="label-form">Provincia</label>
	<input class="form-control" name="provincia" value="<?php echo $prov?>" readonly maxlength="70">

	</div>
	<div class="form-group has-warning">
	  <label class="label-form">Partido</label>
	<input class="form-control" name="partido" value="<?php echo $part?>" readonly maxlength="70">

	</div>
	<div class="form-group has-warning">
	  <label class="label-form">Nombre localidad</label>
	   <input class="form-control" name="nombre" id="nombre" maxlength="70" onblur="valida_0(this.id)" required>
	</div>
	<button class="btn btn-primary">Crear</button>
</form>
</div>