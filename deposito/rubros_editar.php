<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Editar Rubro";
include("encabezado.php"); 
$id=nget("id");
$r=un_registro("select * from articulos_rubros where idarticulos_rubros=".$id);?>
<div class="container">
<form class="form" method="get" action="rubros_do">
  <div class="form-group has-warning">
	<label class="label-form" for="descripcion">Descripci&oacute;n</label>
	<input class="form-control" id="descripcion" name="descripcion" maxlenght="100" onblur='valida_0(this.id)' autofocus required value="<?php echo $r['descripcion']?>">
  </div>
  <input name="id" value="<?php echo $id?>" hidden>
  <button class="btn btn-primary">Guardar</button>	
</form>

</div>
