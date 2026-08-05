<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Usuarios";
if ($_SESSION['gl_usuarios']!="1") redirect('error_noautorizado');
include("encabezado-test.php");
$usua= $_GET["vusuario"];
$conn =registros("select id, denominacion from sectores where baja is null and denominacion like '%DGPPAU%' order by denominacion");
$opci ="";
while ($dt = mysqli_fetch_assoc($conn)) {
$opci=$opci."<option value='".$dt['id']."'>".$dt['denominacion']."</option>";}
$oppe="";
$conn = registros("select id, denominacion from perfiles where denominacion like '%DGPPAU%' order by denominacion");
while ($re = mysqli_fetch_assoc($conn)) {
$oppe=$oppe."<option value='".$re['id']."'>".$re['denominacion']."</option>";};

	$sql="select apellido, usuarios.nombre, email, password, sector, denominacion, perfil, cuil 
  from usuarios 
  left join sectores on sector=sectores.id
  where usuarios.id=".$usua." and sectores.denominacion like '%DGPPAU%' ";
	$conn=registros($sql);;
	$cant = mysqli_num_rows($conn);

$apel="";
$nomb="";
$mail="";
$pass="";
$sect="";
$perf="";

if ($cant==1) {
  $re = mysqli_fetch_assoc($conn);
  $apel=$re['apellido'];
  $cuil=$re['cuil'];
  $nomb=$re['nombre'];
  $mail=$re['email'];
  $pass=$re['password'];
  $disp=$re['sector'];
  $perf=$re['perfil'];

};

?>
</div>
<div class="container">

<form class="form" method='post' action='usuario_dgppau_actualiza' onsubmit='return valida()' enctype='multipart/form-data'>

<div class="form-group has-warning">
<label class="label-form" for="apellido">Apellido</label>
<input class='form-control' onchange='valida_0(this.id)' name='apellido' id='apellido' value='<?php echo $apel;?>' required autofocus></td>
</div>
<div class="form-group has-warning">
<label class="label-form" for="nombre">Nombre</label>
<input class='form-control' onchange='valida_0(this.id)' name='nombre' id='nombre' value='<?php echo $nomb;?>' required>
</div>
<div class="form-group has-warning">
<label class="label-form" for="cuil">CUIL</label>
<input class="form-control" size='11' maxlength='11' onblur='valida()' name='cuil' id='cuil' value='<?php echo $cuil;?>' required>
</div>
<div class="form-group has-warning">
<label class="label-form" for="email">Email</label>
<input class="form-control" maxlength="70" type='text' onchange='valida_mail(this.id)' name='email' id='email' value='<?php echo $mail;?>' required>
</div>
<div class="form-group has-warning">
<label class="label-form" for="password">Password</label>
<input class="form-control" type='password' onchange='valida_0(this.id)' name='password' id='password' value='<?php echo $pass;?>' required>
</div>
<div class="form-group has-warning">
<label class="label-form" for="sector">Sector</label>
<select class="form-control" name='sector' id='sector' required><?php echo $opci;?></select>
</div>
<table>
<div class="form-group has-warning">
<label class="label-form" for="perfil">Perfil</label>
<select class="form-control" name='perfil' id='perfil' required><?php echo $oppe;?></select>
</div>
<input type='hidden' name='id' value='<?php echo $usua;?>'><br>
<input class="bg-primary" type='submit' value='Aceptar'>

<script langtype='text/javascript'>

seleccionar('sector','<?php echo $disp;?>');
seleccionar('perfil',"<?php echo $perf;?>");

function valida(){
if(!validaCuit(document.getElementById('cuil').value)){document.getElementById('cuil').value=""; return false;};
return true;
}
</script>

</form>


</div>

</body>



</html>