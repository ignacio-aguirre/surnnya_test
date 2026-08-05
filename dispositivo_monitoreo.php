<?php
include("Funciones.php");
session_start();
if(!isset($_GET["id"])) Redirect("dispositivos");
if($_SESSION['gl_tablaongs']!="1") header("Location: error_noautorizado");

$id=nget("id");
$_SESSION["prestacion"]="Registrar fecha monitoreo";
$r=un_registro("select * from dispositivos where dispositivos.id=".$id);
include("encabezado-test.php");?>
</div>
<div class="container">
<form class="form" method="get" onsubmit="return valida()" action="dispositivo_monitoreo_do">
    <div class="form-group has-warning">
		<label class="label-form" for="nombre">Dispositivo</label>
		<input class="form-control" id="nombre"  size="80" maxlength="200"  disabled value="<?php echo $r['nombre']?>" >
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="ong">Ong</label>
		<select class='form-control' disabled id='ong'><?php echo tbla("hogares_ong")?></select>
	</div>
	<script>seleccionar("ong","<?php echo $r['ong']?>")</script>
	
	<div class="form-group has-warning">
		<label class="label-form" for="ultimo_monitoreo">&Uacute;ltimo Monitoreo</label>
		<input class="form-control" id="ultimo_monitoreo" name="ultimo_monitoreo" size="10" maxlength="10" value="<?php echo ffec($r['ultimo_monitoreo'])?>" onblur="valida_fecha(this.id,1)">
	</div>
	
	<input hidden name="id" value="<?php echo $id?>">
	<button class="btn btn-primary">Guardar</button>
</form>
</div>
<script>

function valida(){
valida_fecha("ultimo_monitoreo");
status("");
return true;
}

</script>
</body>
