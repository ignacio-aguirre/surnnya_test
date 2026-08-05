<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
if($_SESSION['gl_tablahogares']!="1") header("Location: error_noautorizado");
$id=$_GET['id'];
$r=un_registro("select * from dispositivos where dispositivos.id=".$id); 
$_SESSION["prestacion"]="Editar Dispositivo de Cuidado ".$r["nombre"];
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class='form-inline' method='get' action='un_hogar_do'>
<div class="form-group has-warning">
		<label class="label-form" for="unidad_tecnica">Unidad T&eacute;cnica Supervisi&oacute;n</label>
		<select class="form-control" id="unidad_tecnica" name="unidad_tecnica" autofocus>
		<?php echo opc_tabla("SUPUT");?>
		</select>
	</div>
	<br><br>
<div class="form-group has-warning">
		<label class="label-form" for="direccion_operativa">Direcci&oacute;n Operativa</label>
		<select class="form-control" id="direccion_operativa" name="direccion_operativa" required>
                <option value=""></option>
		<?php echo opc_tabla("DIOP");?>
		</select>
	</div>
	<br><br>

<div class="form-group has-warning">
		<label class="label-form" for="email">Email para notificaciones electr&oacute;nicas</label>
		<input class="form-control" id="Hogares_Mail" name="Hogares_Mail" size="60" maxlength="100" required value="<?php echo $r['Hogares_Mail']?>" onblur="valida_mail(this.id)">
</div>
<br><br>
<div class="form-group has-warning">
		<label class="label-form">Poblaci&oacute;n Objetivo - G&eacute;nero: <?php echo si($r["genero_poblacion"]=="1","Femenino",si($r["genero_poblacion"]==2,"Masculino","Ambos"))?></label>
		<br>
		<label class="label-form">Franja Etaria: de <?php echo $r["etaria_desde"]." a ".$r["etaria_hasta"]?></label>
		<br>
		<label class="label-form">Especificaci&oacute;n</label>
		<input class="form-control" name="poblacion" id="poblacion" size="30" maxlength="50" value="<?php echo $r['poblacion']?>">
</div>
<br><br>
<div class="form-group has-warning">
		<label class="label-form" for="transporte">Empresa m&oacute;viles</label>
		<select class="form-control" id="transporte" name="transporte" required>
                <option value="0"></option>
		<?php echo opc_tabla("ETRA");?>
		</select>
	</div>
	<br><br>

<input type='hidden' name='id' value='<?php echo $id;?>'/>
<input class='btn-primary' type='submit' value='Aceptar'>
</div>
</div>
<script>
seleccionar("unidad_tecnica","<?php echo $r['unidad_tecnica']?>");
seleccionar("direccion_operativa","<?php echo $r['direccion_operativa']?>");
seleccionar("transporte","<?php echo $r['transporte']?>");

</script>
</body>
</html>