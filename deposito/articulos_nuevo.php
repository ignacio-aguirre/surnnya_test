<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Art&iacute;culo Nuevo";
include("encabezado.php"); 
?>
<div class="container">
<form class="form" method="get" action="articulos_do" onsubmit="return valida()">
  <div class="form-group has-warning">
	<label class="label-form" for="descripcion">Descripci&oacute;n</label>
	<input class="form-control" id="descripcion" name="descripcion" maxlenght="100" onblur='valida_0(this.id)' autofocus required>
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="rubro">Rubro</label>
	<select class="form-control" id="rubro" name="rubro" required>
        <?php echo str_replace("'0'","''",opciones('articulos_rubros'));?></select>
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="tipo_bien">Tipo de bien</label>
	<select class="form-control" id="tipo_bien" name="tipo_bien" required>
	 <option value="1">Bien de Consumo</option>
	 <option value="2">Bien de Uso</option>
	</select>
  </div>
 <div class="form-group has-warning">
  <label class="label-form" for="tipo_bien">Tiene vencimiento?</label>
  <select class="form-control" id="vencimiento" name="vencimiento" required>
   <option value="0">No</option>
   <option value="1">Si</option>
  </select>
  </div>

  <input name="id" value="0" hidden>
  <button class="btn btn-primary">Guardar</button>	
</form>
<script>
function valida(){
  desc=document.getElementById("descripcion").value;
  if(desc!=""){
  id=ejec_sq("ej_tablas?tipo=ARTICULO_CONS&descripcion="+desc);
  if(id>0){status("Art. Existente");return false;};
  };
 return true;
}
</script>  
</div>
