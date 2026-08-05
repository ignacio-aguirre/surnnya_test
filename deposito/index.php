<?php
session_start();
session_destroy();
session_start();
include("static/par-conexion.php");
include("funciones.php");
include('encabezado-index.php');
$mail="";
$pass="";
?>
<script>
function valida(){
navega("validaingreso?user="+document.getElementById("user").value+"&password="+document.getElementById("password").value);
}
function envia(){
navega("envio_password");
}

</script>
<div class="container" align="center">
<form class="form-inline" onsubmit="return false">
 <div class="form-group has-warning">
  <label for="user" class="label-form">Mail del Usuario</label>
  <input class="form-control" id="user" name="user" size="45" maxlength="45" value="<?php echo $mail;?>"> 
 </div>
 <br><br>
 <div class="form-group has-warning">
  <label for="password" class="label-form">Contrase&ntilde;a</label>
  <input class="form-control" id="password" name="password" type="password" size="15" maxlength="15" value='<?php echo $pass;?>'>
 </div>
 <br><br>  
 <button class="btn btn-primary" type="submit" onclick="script:valida()">Ingresar</button>
 <hr>
 <button class="btn btn-info" type="submit" onclick="script:envia()">Env&iacute;enme mi contrase&ntilde;a</button>
</form>
<?php include('footer.php');?>
</div>
<script>document.getElementById("user").focus();</script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js">
</script>
<script src="js/generales.js"></script>

</body>
</html>