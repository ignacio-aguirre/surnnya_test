<?php 
include("funciones.php");
session_start();
$baja=isset($_GET["baja"]);
$_SESSION["prestacion"]=si($baja,"Baja","Editar")." Efector";
include("encabezado.php"); 
$id=nget("id");
$r=un_registro("select * from efectores where idefectores=".$id);
if(!$baja)  {?>
<div class="container">
<form class="form-inline" method="get" action="efectores_do" onsubmit="return valida()">
  <div class="form-group has-warning">
	<label class="label-form" for="descripcion">Descripci&oacute;n</label>
	<input class="form-control" id="descripcion" name="descripcion" size="50" maxlength="100" onblur='valida_0(this.id)' value="<?php echo $r['descripcion']?>" autofocus required>
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="domicilio">Domicilio</label>
        <input class="form-control" id='domicilio' name='domicilio' size='40' maxlength='45' onblur='valida_0(this.id)' value="<?php echo $r['domicilio']?>" required>&nbsp;
  </div>
  <div class="form-group has-warning">
      <label class="label-form" for="localidad">Localidad</label>
      <input class="form-control" id='localidad' name='localidad' size='20' maxlength='45' onblur='valida_0(this.id)' required value="<?php echo $r['localidad']?>" readonly>
  </div>
  <br><br>
  <div class="form-group has-warning">
     <label class="label-form" for="barrio">Barrio</label>
     <input  class="form-control" id='barrio' name='barrio' size='40' maxlength='45' onblur='valida_0(this.id)' value="<?php echo $r['barrio']?>" required>&nbsp;
  </div>
  <div class="form-group has-warning">
    <label class="label-form" for="comuna">Comuna</label>
    <input class="form-control" id='comuna' name='comuna' type='number' min='1' max='15'  value="<?php echo $r['comuna']?>" required>
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="telefonos">Tel&eacutefonos</label>
	<input  class="form-control" id='telefonos' name='telefonos' size='40' maxlength='45' onblur='valida_0(this.id)'  value="<?php echo $r['telefonos']?>" required>
  </div>
  <br><br>
  <div class="form-group has-warning">
   <input name="id"  value="<?php echo $id?>" hidden>
   <button class="btn btn-primary">Guardar</button>	
  </div>
</form>
<?php }else{?>
<div class="container">
<form class="form" onsubmit="return baja()">
  <div class="form-group has-warning">
	<label class="label-form" for="descripcion">Descripci&oacute;n</label>
	<input readonly class="form-control" id="descripcion" name="descripcion" maxlenght="100" onblur='valida_0(this.id)' autofocus required value="<?php echo $r['descripcion']?>">
  </div>
  <input name="id" id="id" value="<?php echo $id?>" hidden>
  <button class="btn btn-danger">Confirmar Baja</button>	
</form>
<?php }?>
<script>
function valida(){
  desc=document.getElementById("descripcion").value;
  if(desc!=""){
  id=ejec_sq("ej_tablas?tipo=EFECTOR_CONS_ED&descripcion="+desc+"&id=<?php echo $id?>");
   if(id>0){status("Efector Existente");return false;};
  };
 return true;
}
function baja(){
  navega("ej_tablas?tipo=EFECTOR_BAJA&id=<?php echo $id?>");
  return false;
}
</script>  
</div>
