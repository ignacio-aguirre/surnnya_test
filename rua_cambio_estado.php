<?php
/* a eliminar */
include("Funciones.php"); 
session_start();
if(isset($_GET["id"])){
	$id=$_GET["id"];
}else {
	Redirect("rua_nomina");
};
$_SESSION['prestacion']="Cambio de estado de registro ".un_campo("select registro from rua_nomina where id=".$id);
include("encabezado-test.php");
?>
<div class="container">
	<form class="form" method="get" action="rua_cambio_estado_do">
		<input hidden name="id" value="<?php echo $id?>">
		<div class="form-group has-warning">
			<label class="label-form">Nuevo estado</label>
			<select class="form-control" id="estado" name="estado">
				<?php echo opc_tabla('ERUA')?>
			</select>	
		</div>
		<div class="form-group has-warning">
			<label class="label-form">Comentarios</label>
			<input class="form-control" id="comentarios" name="comentarios" maxlength="70">
		</div>
		<button class="btn btn-success">Guardar</button>
	</form>
</div>
<script>
	seleccionar("estado","<?php echo un_campo('select estado from rua_nomina where id='.$id)?>");
</script>