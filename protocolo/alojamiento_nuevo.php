<?php 
include("funciones.php");
session_start();
$_SESSION["titulo"]="Alojamientos -nuevo ingreso";
tranca();
include("encabezado-test.php");
$id=$_SESSION["caso"];
$nya=un_campo("select concat(apellidos,', ',nombres)  from casos where idcasos=".$id);
$_SESSION['Hoy']=un_campo("select curdate() as hoy");
$fult=un_campo("select max(f_egreso) from alojamientos where f_egreso is not null and caso=".$id);
?>
<div class="container" align="center">
<h4>Nuevo ingreso de <?php echo $nya?></h4>
</div>
<div class="container">
	<form class="form" method="post" action="alojamiento_nuevo_do">
		<input name="id" value="<?php echo $id?>" hidden>
		<div class="form-group has-warning col-md-8">
			<label class="label-form" for="dispositivo">Dispositivo al que ingres&oacute;</label>
			<input class="form-control" autofocus name="dispositivo" id="dispositivo" onblur="valida_0(this.id)" size="40"	maxlength="80" required>
		</div>	
		<div class="form-group has-warning col-md-2">
			<label class="label-form" for="f_ingreso">Fecha del ingreso</label>
			<input class="form-control" name="f_ingreso" id="f_ingreso" type="date" min="<?php echo $fult?>" max="<?php echo $_SESSION['Hoy']?>" value="<?php echo $_SESSION['Hoy']?>"  required	>
		</div>
		<button class="btn-sm btn-success">Registrar ingreso</button>	
	</form>	
</div>