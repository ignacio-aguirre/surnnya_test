<?php
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Nuevo usuario de dispositivos conveniados";
include("encabezado.php");
$dispositivo=nget("dispositivo");

?>
</div>
<br>
<div class="container">
<div class="row">
<form class="form" method="get" onsubmit="return valida()" action="mv_usuarios_nuevo_do">
 <div class="form-group has-warning">
  <label class="label-form">Apellidos</label>
  <input class="form-control" autocomplete="off" name="apellidos" id="apellidos" size="50" maxlength="70" autofocus required onblur="valida_0(this.id)">
 </div>
 <div class="form-group has-warning">
  <label class="label-form">Nombres</label>
  <input class="form-control" autocomplete="off"  name="nombres" id="nombres" size="50" maxlength="70" required onblur="valida_0(this.id)">
 </div>
 
</div>
 
 
 
 

<div class="row">
 <div class="form-group has-warning">
  <label class="label-form">Email</label>
  <input class="form-control" name="email" id="email" size="50" maxlength="50"  onblur="valida_mail(this.id)">
 </div>
 </div>
 <div class="row">
 
 <div class="form-group has-warning">
  <label class="label-form">Usuario</label>
  <input class="form-control" name="acronimo" id="acronimo" onfocus="c_acro()" autocomplete="off" size="35" maxlength="35" required>
 </div>

</div>
 
 <input hidden name="dispositivo" value="<?php echo $dispositivo?>">
 
 <input class="btn-primary" type="submit" value="Guardar">

</form>
</div>
<script>

function valida(){
valida_0("apellidos");
valida_0("nombres");
valida_0("acronimo");
valida_mail("email");
existe=eje("val_acronimo?acronimo="+document.getElementById("acronimo").value);
if(existe>"0") {
    status("ya existe ese usuario");
    return false;}
return true;
}
function c_acro(){
    if(document.getElementById("acronimo").value==""){
    document.getElementById("acronimo").value=izq(document.getElementById("nombres").value,1)+izq(document.getElementById("apellidos").value,9);
};
}
</script>
</body>
</html>
