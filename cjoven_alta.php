<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Nueva Alta en Casa Joven";
include("encabezado.php");
$legajo=$_GET["legajo"];
$cantidad=un_campo("select count(*) from cjoven_nomina where legajo=".$legajo);
$activas=un_campo("select count(*) from cjoven_nomina where legajo=".$legajo." and baja is null");

?>
</div>
<div class="container">
<?php
if($activas>"0"){die("Adolescente tiene una alta activa");};
if($cantidad>"0"){
echo "<p class='warning-text'> Adolescente tiene ".$cantidad." altas ya registradas</p>";};
?>
<h4><?php echo un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$legajo)?></h4>
<form class="form-inline" method="GET" action="cjoven_alta_do" onsubmit="return valida()">
<div class="form-group has-warning">
<label class="label-form" for="fecha">Fecha de Alta</label>
<input class="form-control" id="fecha" name="fecha" size="10" maxlength="10" onblur="valida_fecha(this.id,1)">
<input name="legajo" hidden value="<?php echo $legajo?>">
<button class="btn btn-primary" type="submit">Registrar</button>
</div>
</form>
</div>
<script>
enfoca("fecha");
function valida(){
valida_fecha("fecha",1);
if(document.getElementById("fecha").value==""){status("completar fecha de alta");return false;};
status("");
return true;
}
</script>
</body>