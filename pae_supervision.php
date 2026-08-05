<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Supervision de PAE";
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$id=$_GET["id"];
$r=un_registro("select * from pae_supervisiones where idpae_supervisiones=".$id);

$deno=un_campo("select concat(apellidos,', ', nombres) as deno from sujetos where legajo=".$r["legajo"]);
?>

</div>

<div class="container">

<h4><?php echo $deno;?></h4>

<form class="form-inline" onsubmit="return false" enctype="multipart/form-data">

<div class="form-group has-warning">
<label class="label-form" for="fecha">Fecha de la Supervisi&oacute;n</label>

<input class="form-control" size='8' maxlength='10' name='fecha' id='fecha' value="<?php echo ffec($r['fecha'])?>">

</div>

<div class="form-group has-warning">
<label class="label-form" for="lugar">Lugar en que se realizó</label>
<input class="form-group" size="40" maxlength="45" id="lugar" name="lugar" value="<?php echo $r['lugar']?>">
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="supervisores">Supervisores</label>
<input class="form-group" size="40" maxlength="45" id="supervisores" name="supervisores" value="<?php echo $r['supervisores']?>">
</div>
<hr>

<div class="form-group has-warning">
<label class="label-form" for="salud">Salud / Salud Sexual / Procreación Responsable y Planificación Familiar</label><br>
<textarea id="salud" name="salud" cols="120" rows="4"><?php echo $r['salud']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="educacion">Educación, formación y empleo</label><br>
<textarea id="educacion" name="educacion" cols="120" rows="4"><?php echo $r['educacion']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="vivienda">Vivienda</label><br>
<textarea id="vivienda" name="vivienda" cols="120" rows="4"><?php echo $r['vivienda']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="derechos">Derechos Humanos y Formación Ciudadana</label><br>
<textarea id="derechos" name="derechos" cols="120" rows="4"><?php echo $r['derechos']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="familia">Familia y Redes Sociales</label><br>
<textarea id="familia" name="familia" cols="120" rows="4"><?php echo $r['familia']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="recreacion">Recreación y Tiempo Libre</label><br>
<textarea id="recreacion" name="recreacion" cols="120" rows="4"><?php echo $r['recreacion']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="habilidades">Habilidades para la vida independiente</label><br>
<textarea id="habilidades" name="habilidades" cols="120" rows="4"><?php echo $r['habilidades']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="identidad">Identidad</label><br>
<textarea id="identidad" name="identidad" cols="120" rows="4" ><?php echo $r['identidad']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="finanzas">Planificación financiera y manejo del dinero</label><br>
<textarea id="finanzas" name="finanzas" cols="120" rows="4"><?php echo $r['finanzas']?></textarea>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="archivo">Documento Asociado</label><br>
<?php 
$link="";
if($r["archivo"]>"0"){$link=un_campo("select as_path from archivos_subidos where idarchivos_subidos=".$r["archivo"]);};?>
<iframe allowfullscreen width="800" height="800" src="<?php echo $link?>"/>
</div>
<hr>
</form>
</div>



<script type="text/javascript">

enfoca('fecha');

function valida_datos() {

var sc=<?php echo $_SESSION['glcons'];?>;

if(sc=="1"){alert("Su perfil es de solo consulta"); return false;};


if (document.getElementById("fecha").value.length==0) {alert("Indique Fecha de Supervision");return false;};

hoy="<?php echo $_SESSION['DiaHoy']?>";

if (fsql(document.getElementById("fecha").value)>fsql(hoy)){alert("Nonono, no acepto fechas del futuro");return false;};
if (document.getElementById("lugar").value.length==0) {alert("Indique Lugar de Supervision");return false;};
if (document.getElementById("supervisores").value.length==0) {alert("Indique Supervisores");return false;};

return true;

}

</script>
</body>
</html>