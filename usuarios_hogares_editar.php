<?php
include("Funciones.php");
session_start();
$id=nget("id");
$_SESSION["prestacion"]="Editar datos de usuario de hogares";
include("encabezado.php");
$r=un_registro("select * from usuarios_hogares where id=".$id);
$hogar=$r["hogar"];
if(isset($_GET["hogar"])){$hogar=nget("hogar");};
?>
</div>
<div class="container">
<div class="row">
<form class="form-inline" method="get" onsubmit="return valida()" action="usuarios_hogares_editar_do">
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Apellidos</label>
  <input class="form-control" autocomplete="off" name="apellidos" id="apellidos" size="25" maxlength="30" autofocus required onblur="valida_0(this.id)" value="<?php echo $r["apellidos"]?>">
 </div>
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Nombres</label>
  <input class="form-control" autocomplete="off"  name="nombres" id="nombres" size="25" maxlength="30" required onblur="valida_0(this.id)" value="<?php echo $r["nombres"]?>">
 </div>
 <div class="form-group has-warning col-md-4">
  <label class="label-form">DNI</label>
  <input class="form-control"  autocomplete="off" name="dni" id="dni" size="9" maxlength="9" required onblur="valida_entero(this.id)" value="<?php echo $r["dni"]?>">
 </div>
</div><br><br>
 <?php if($hogar!="398"){?>
 <div  class="row"> 
 
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Firma Informes?</label>
  <input class="form-control"  type="checkbox" name="firma"  id="firma"<?php if($r["firma"]=="1") echo " checked "?>>
 </div>
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Profesi&oacute;n</label>
  <input class="form-control pro tri" name="profesion" id="profesion" size="30" maxlength="50" value="<?php echo $r["profesion"]?>">
 </div>
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Matr&iacute;cula</label>
  <input class="form-control pro" name="matricula" id="matricula" size="30" maxlength="30" value="<?php echo $r["matricula"]?>">
 </div>
</div>
<div class="row">
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Es usuario multihogar?</label>
  <input class="form-control pro " type="checkbox" name="es_multihogar" id="es_multihogar" <?php echo si($r["es_multihogar"]=="1","checked","")?>>
 </div>
 
<?php }?>
<div class="row">
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Email</label>
  <input class="form-control pro" name="email" id="email" size="50" maxlength="50" value="<?php echo $r["email"]?>" onblur="valida_mail(this.id)">
 </div>
 </div>
 <div class="row">
 <h4>Ingreso al sistema</h4>
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Usuario</label>
  <input class="form-control" name="descripcion" id="descripcion" autocomplete="off" size="35" maxlength="35" value="<?php echo $r["descripcion"]?>" required>
 </div>
 
 <div class="form-group has-warning col-md-4">
  <label class="label-form">Perfil m&oacute;viles</label>
  <select class="form-control" name="perfil_moviles" id="perfil_moviles">
	 <?php if($hogar!="398"){?>
	    <option value="0">No usuario de mv</option>
	    <option value="1">Usuario de dispositivo</option>
	<?php } else{?>
    <option value="3">Usuario de supervisi&oacute;n</option> <?php };?>

    
  </select>
  <script>seleccionar("perfil_moviles","<?php echo $r['perfil_moviles']?>")</script>
 </div>
</div>
 <input hidden name="id" value="<?php echo $id?>">
 <input hidden name="hogar" value="<?php echo si(!($r["hogar"]>"0"),$hogar,$r["hogar"])?>">
 <hr>
 <input class="btn-primary" type="submit" value="Guardar">

</form>
</div>
<script>

function valida(){
valida_0("profesion");
valida_0("matricula");
valida_0("descripcion");
valida_entero("dni");
valida_mail("email");
return true;
}

</script>
</body>
</html>
