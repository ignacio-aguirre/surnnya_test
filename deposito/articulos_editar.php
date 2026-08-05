<?php 
include("funciones.php");
session_start();
$baja=isset($_GET["baja"]);
$_SESSION["prestacion"]=si($baja,"Baja","Editar")." Art&iacute;culo";
include("encabezado.php"); 
$id=nget("id");

$r=un_registro("select * from articulos where baja is null and idarticulos=".$id);
if(!$baja)  {?>
<div class="container">
<form class="form" method="get" action="articulos_do" onsubmit="return valida()">
  <div class="form-group has-warning">
	<label class="label-form" for="descripcion">Descripci&oacute;n</label>
	<input class="form-control" id="descripcion" name="descripcion" maxlenght="100" onblur='valida_0(this.id)' autofocus required value="<?php echo $r['descripcion']?>">
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="rubro">Rubro</label>
	<select class="form-control" id="rubro" name="rubro" required>
        <?php echo str_replace("'0'","''",opciones('articulos_rubros'));?></select>
	<script>seleccionar("rubro","<?php echo $r['rubro']?>");</script>
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="tipo_bien">Tipo de bien</label>
	<select class="form-control" id="tipo_bien" name="tipo_bien" required>
	 <option value="1">Bien de Consumo</option>
	 <option value="2">Bien de Uso</option>
	</select>
  </div>
  <script>seleccionar("tipo_bien","<?php echo $r['tipo_bien']?>");</script>
<div class="form-group has-warning">
  <label class="label-form" for="tipo_bien">Tiene vencimiento?</label>
  <select class="form-control" id="vencimiento" name="vencimiento" required>
   <option value="0">No</option>
   <option value="1">Si</option>
  </select>
  </div>
  <script>seleccionar("vencimiento","<?php echo $r['vencimiento']?>");</script>
  <input name="id" value="<?php echo $id?>" hidden>
  <button class="btn btn-primary">Guardar</button>	
</form>
<?php }else{?>
<div class="container">
<form class="form" onsubmit="return baja()">
  <div class="form-group has-warning">
	<label class="label-form" for="descripcion">Descripci&oacute;n</label>
	<input readonly class="form-control" id="descripcion" name="descripcion" maxlenght="100" onblur='valida_0(this.id)' autofocus required value="<?php echo $r['descripcion']?>">
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="rubro">Rubro</label>
	<select class="form-control" id="rubro" name="rubro" required>
        <?php echo str_replace("'0'","''",opciones('articulos_rubros'));?></select>
	<script>seleccionar("rubro","<?php echo $r['rubro']?>");</script>
  </div>
  <input name="id" id="id" value="<?php echo $id?>" hidden>
  <button class="btn btn-danger">Confirmar Baja</button>	
</form>

<?php }?>
<script>
function valida(){
    return true;
}

function baja(){
  navega("ej_tablas?tipo=ARTICULO_BAJA&id="+document.getElementById("id").value);
  return false;
}
</script>  
</div>
