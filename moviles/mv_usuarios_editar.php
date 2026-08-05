<?php
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Editar usuario de dispositivos conveniados";
include("encabezado.php");
$id=nget("id");
$u=un_registro("select * from movil_usuarios where id=".$id);
?>
</div>
<br>
<div class="container">
<div class="row">
<form class="form" method="get" onsubmit="return valida()" action="mv_usuarios_editar_do">
    <input hidden name="id" id="id" value="<?php echo $id?>">
 <div class="form-group has-warning">
  <label class="label-form">Apellidos</label>
  <input class="form-control" name="apellidos" id="apellidos" size="50" maxlength="70" autofocus required onblur="valida_0(this.id)" value="<?php echo $u['apellidos']?>">
 </div>
 <div class="form-group has-warning">
  <label class="label-form">Nombres</label>
  <input class="form-control" autocomplete="off"  name="nombres" id="nombres" size="50" maxlength="70" required onblur="valida_0(this.id)" value="<?php echo $u['nombres']?>">
 </div>
 
</div>
 
<div class="row">
 <div class="form-group has-warning">
  <label class="label-form">Email</label>
  <input class="form-control" name="email" id="email" size="50" maxlength="50"  onblur="valida_mail(this.id)" value="<?php echo $u['email']?>">
 </div>
 </div>
 <div class="row">
 
 <div class="form-group has-warning">
  <label class="label-form">Usuario</label>
  <input class="form-control" name="acronimo" id="acronimo" autocomplete="off" size="35" maxlength="35" required value="<?php echo $u['acronimo']?>">
 </div>
</div>
 <div class="row">
 <div class="form-group has-warning">
  <label class="label-form">Password</label>
  <input class="form-control" name="password" id="password" autocomplete="off" size="35" maxlength="35" required value="<?php echo $u['password']?>">
 </div>
</div>
 
 
 
 <input class="btn-primary" type="submit" value="Guardar">

</form>
</div>
<script>

function valida(){
valida_0("apellidos");
valida_0("nombres");
valida_0("acronimo");
valida_0("password");
valida_mail("email");
id=eje("val_acronimo2?acronimo="+document.getElementById("acronimo").value);
if(id!=document.getElementById("id").value) {
    status("ya existe ese usuario");
    return false;}
return true;
}

</script>
</body>
</html>
