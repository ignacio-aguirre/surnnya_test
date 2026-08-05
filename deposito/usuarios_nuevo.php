<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Nuevo Usuario";
include("encabezado.php"); 
?>
<div class="container">
<form class="form-inline" onsubmit="return valida()" action="usuarios_do" method="GET">
   <input name="id" hidden value="0">
   <div class="row">
   <div class="form-group has-warning col-md-4">
    <label class="label-form" for="apellido">Apellido</label>
    <input class="form-control" id='apellido' name='apellido' size="45" maxlength='45' onblur='valida_0(this.id)' required>
   </div>
   <div class="form-group has-warning col-md-4">
    <label class="label-form" for="nombre">Nombre</label>
    <input class="form-control" id='nombre' name='nombre' size="45" maxlength='45' onblur='valida_0(this.id)' required>
   </div></div><br><br>
   <div class="row">
   <div class="form-group has-warning col-md-3">
    <label class="label-form" for="cuil">CUIL</label>
    <input class="form-control" id='cuil' name='cuil' size="11" maxlength='11' onblur='validaCuit(this.id)' placeholder="sin guiones" required>
   </div>
   <div class="form-group has-warning col-md-3">
    <label class="label-form" for="email">Email</label>
    <input class="form-control" id='email' name='email' size="30" maxlength='45' onblur='valida_mail(this.id)' required  autocomplete="nope">
   </div>
   </div><br><br>
   <div class="row">
   <div class="form-group has-warning col-md-4">
    <label class="label-form" for="rol">Rol</label>
    <select class="form-control" id='rol' name='rol' required>
     <option value=""></option>
     <option value="2">Adm.Dep&oacute;sito</option>
     <option value="1">Adm.Sistema</option>
    </select>
   </div></div><br><br>
   <button class='btn btn-primary'>Guardar</button>
</form>
</div>
<script>
function valida(){
return true;
}
</script>
</body>
</html>



