<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Nuevo Usuario";

if ($_SESSION['glidperfil']!="73") Redirect('error_noautorizado');
include("encabezado-test.php");
$dis =registros("select id, denominacion from sectores where baja is null and denominacion like '%DGPPAU%' order by denominacion");
$dispo ="";
while ($d = mysqli_fetch_assoc($dis)) {
$dispo=$dispo."<option value='".$d['id']."'>".$d['denominacion']."</option>";}
$perf="";
$per = registros("select id, denominacion from perfiles where denominacion like '%DGPPAU%' order by denominacion");
while ($p = mysqli_fetch_assoc($per)) {
$perf=$perf."<option value='".$p['id']."'>".$p['denominacion']."</option>";};
$micorreo=un_campo("select email from usuarios where id=".$_SESSION["glidusua"]);
?>
</div>
<div class="container">
<form class="form-inline" method='post' action='usuario_dgppau_nuevo_do' onsubmit='return valida()'>
<div class="form-group has-warning">
<label class="label-form" for="cuil">CUIL</label>
<input class="form-control" size='11' maxlength='11' onblur='valida()' name='cuil' id='cuil' required autofocus>
<var class="form-control" id="respuesta"></var>
</div><br><br>
<div class="form-group has-warning">
<label class="label-form" for="apellido">Apellido</label>
<input class='form-control' onchange='valida_0(this.id)' name='apellido' id='apellido' size="40" maxlength="45" required>
</div>&nbsp;&nbsp;
<div class="form-group has-warning">
<label class="label-form" for="nombre">Nombre</label>
<input class='form-control' onchange='valida_0(this.id)' onblur="propone()" name='nombre' id='nombre' size="40" maxlength="45" required>
</div><br><br>
<div class="form-group has-warning">
<label class="label-form" for="email">Email</label>
<input class="form-control" size="50" maxlength="70" type='text' onfocus='propone()' onblur='valida_mail(this.id)' name='email' id='email' required autocomplete="nope">
</div><br><br>
<div class="form-group has-warning">
<label class="label-form" for="sector">Sector</label>
<select class="form-control" name='sector' id='sector'><?php echo $dispo;?></select>
</div>&nbsp;&nbsp;
<div class="form-group has-warning">
<label class="label-form" for="perfil">Perfil</label>
<select class="form-control" name='perfil' id='perfil'><?php echo $perf;?></select>
</div><br><br>
<input class="bg-primary" type='submit' value='Aceptar'>

<script langtype='text/javascript'>
function valida(){
if(!validaCuit(document.getElementById('cuil').value)){
  document.getElementById('cuil').value=""; 
  document.getElementById("respuesta").innerHTML="CUIL INVALIDO";
  return false;
};

resp=ejec_sq("sq_usuario?cuil="+document.getElementById('cuil').value);
status(resp);
document.getElementById("respuesta").innerHTML=resp;

if(resp==""){ return true;};
if(resp.indexOf("BAJA")>0){
  if(confirm(resp+". Restauras el usuario?")){
    navega("usuario_dgppau_restaura?cuil="+document.getElementById('cuil').value);
  };
};
if(resp.indexOf("ACTIVO")>0){
  return false;
};  
document.getElementById("cuil").value="";
document.getElementById("apellido").value="";
document.getElementById("nombre").value="";
document.getElementById("email").value="";
document.getElementById("sector").value="";
document.getElementById("perfil").value="";
return true;
}

function propone(){
 prop=izq(document.getElementById("nombre").value.toLowerCase(),1)+document.getElementById("apellido").value.toLowerCase()+"@buenosaires.gob.ar";
 valo=document.getElementById("email").value.toLowerCase();
 mico="<?php echo $micorreo?>".toLowerCase();
 if(valo==mico){document.getElementById("email").value=prop;};
 if(valo=="") {document.getElementById("email").value=prop;};
}
</script>

</form>

</div>

</body>



</html>