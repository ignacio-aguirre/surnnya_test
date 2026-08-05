<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Usuarios";
if ($_SESSION['gl_usuarios']!="1") redirect('error_noautorizado');
include("encabezado-test.php");
$usua= $_GET["vusuario"];
$conn =registros("select id, denominacion from sectores where baja is null order by denominacion");
$opci ="";
while ($dt = mysqli_fetch_assoc($conn)) {
$opci=$opci."<option value='".$dt['id']."'>".$dt['denominacion']."</option>";}
$oppe="";
$conn = registros("select id, denominacion from perfiles order by denominacion");
while ($re = mysqli_fetch_assoc($conn)) {
$oppe=$oppe."<option value='".$re['id']."'>".$re['denominacion']."</option>";};

	$sql="select apellido, usuarios.nombre, email, password, sector, denominacion, perfil, cuil ,tipo_usuario,dispositivo 
  from usuarios 
  left join sectores on sector=sectores.id
  where usuarios.id=".$usua;
	$conn=registros($sql);;
	$cant = mysqli_num_rows($conn);

$apel="";
$nomb="";
$mail="";
$pass="";
$sect="";
$perf="";
$tipo="";
$disp="";
if ($cant==1) {
  $re = mysqli_fetch_assoc($conn);
  $apel=$re['apellido'];
  $cuil=$re['cuil'];
  $nomb=$re['nombre'];
  $mail=$re['email'];
  $pass=$re['password'];
  $sect=$re['sector'];
  $perf=$re['perfil'];
  $tipo=$re['tipo_usuario'];
  $disp=$re['dispositivo'];
};

?>
</div>
<div class="container">

<form class="form" method='post' action='usuarioactualiza' onsubmit='return valida()' enctype='multipart/form-data'>

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
  <label class="label-form" for="tipo_usuario">Tipo usuario</label>
  <select class="form-control" name="tipo_usuario" id="tipo_usuario" onblur="bl_tipo()">
    <option value="A">Agente GCABA</option>
    <option value="D">Agente dispositivo conveniado</option>
  </select>  
</div>  
<div class="form-group has-warning">
<label class="label-form" for="sector">Sector</label>
<select class="form-control" name='sector' id='sector' required><?php echo $opci;?></select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="perfil">Perfil</label>
<select class="form-control" name='perfil' id='perfil' required><?php echo $oppe;?></select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="dispositivo">Dispositivo</label>
<select class="form-control" name='dispositivo' id='dispositivo' required>
  <?php
    $di=registros("select id, nombre from dispositivos where ong>=0 and baja is null and nomina_hogares=1 order by nombre");
    while($d=mysqli_fetch_assoc($di)){
      echo "<option value=".$d["id"].">".$d["nombre"]."</option>";
    };
  ?>
</select>
</div>

<input type='hidden' name='id' value='<?php echo $usua;?>'><br>
<input class="bg-primary" type='submit' value='Aceptar'>

<script langtype='text/javascript'>
seleccionar('tipo_usuario','<?php echo $tipo;?>');
seleccionar('sector','<?php echo $sect;?>');
seleccionar('perfil',"<?php echo $perf;?>");
seleccionar('dispositivo','<?php echo $disp;?>');
bl_tipo();
function valida(){
if(!validaCuit(document.getElementById('cuil').value)){document.getElementById('cuil').value=""; return false;};
return true;
}
function bl_tipo(){
  tipo=document.getElementById("tipo_usuario").value;
  if(tipo=="A"){
    document.getElementById("sector").disabled=false;
    document.getElementById("perfil").disabled=false;
    document.getElementById("dispositivo").disabled=true;
    document.getElementById("dispositivo").value="0";
  }
  else{
    document.getElementById("sector").value="0";
    document.getElementById("sector").disabled=true;
    document.getElementById("perfil").value="0";
    document.getElementById("perfil").disabled=true;
    document.getElementById("dispositivo").disabled=false;
  }
}
</script>

</form>


</div>

</body>



</html>