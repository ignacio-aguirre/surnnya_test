<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Nueva Inclusi&oacute;n en PAE";

include("encabezado-test.php");

if (!isset($_SESSION['gldispo'])) header ("Location: salir");

registre();

$lega=$_GET["legajo"];

$fped=$_SESSION['DiaHoy'];

$id="";

if(isset($_GET["fecha"])) $fped=$_GET["fecha"];

if(isset($_GET["id"])) $idd=$_GET["id"];

$deno=un_campo("select concat(apellidos,', ', nombres) as deno from sujetos where legajo=".$lega);

$cantidad=un_campo("select count(*) from pae_nomina where legajo=".$lega." and f_baja is null");
?>

</div>

<div class="container">

<h4><?php echo $deno;?></h4>

<?php 
if($cantidad>"0") die("Este adolescente est&aacute; incluido<br>Presion&aacute; (atr&aacute;s) para continuar");
?>

<form class="form-inline" action='pae_nomina_do' method="get" onsubmit="return valida_datos()">

<div class="form-group has-warning">

<label class="label-form" for="fecha">Fecha de Inclusi&oacute;n en PAE</label>

<input class="form-control" size='8' maxlength='10' name='fecha' id='fecha' onblur='valida_fecha(this.id)'>

</div>

<div class="form-group has-warning">

<label class="label-form" for="etapa">Etapa</label>
<select class="form-control" id="etapa" name="etapa">
<option value=1>Etapa 1</option>
<option value=2>Etapa 2</option>
</select>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="comentarios">Comentarios</label>
<input class='form-control' size='60' maxlength='200' name='comentarios' id='comentarios'>
</div>

<input type="hidden" name="legajo" value="<?php echo $lega;?>">

<input type="hidden" name="id" value="<?php echo $id;?>">

<button class='btn-primary' type='submit'>Incluir</button>

</form>
<p class="text-warning">Deber&aacute; subir al legajo tambi&eacute;n el documento correspondiente</p>
</div>



<script type="text/javascript">

enfoca('fecha');

function valida_datos() {

var sc=<?php echo $_SESSION['glcons'];?>;

if(sc=="1"){alert("Su perfil es de solo consulta"); return false;};

if (document.getElementById("solicitante").value=="") {status("Indique solicitante");return false;};

if (document.getElementById("fecha").value.length==0) {alert("Indique Fecha de Solicitud");return false;};

hoy="<?php echo $_SESSION['DiaHoy']?>";

if (fsql(document.getElementById("fecha").value)>fsql(hoy)){alert("Nonono, no acepto fechas del futuro");return false;};

return true;

}

</script>
</body>
</html>