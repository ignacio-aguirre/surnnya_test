<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
$legajo=nget("legajo");
$apyn=un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$legajo);
$r=un_registro("select * from sujetos_talles where legajo=".$legajo);
?>
<div class="container">
	<h5>Talles <?php echo $apyn?></h5>
	<form class="form" action="talles_do" method="get">
		<div class="form-group has-warning">
			<label class="label-form" for="rint">Ropa interior</label>
			<input class="form-control" id="rint" name="rint" value="<?php echo $r['rint']?>" autofocus onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="medi">Medias</label>
			<input class="form-control" id="medi" name="medi" value="<?php echo $r['medi']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="reme">Remeras</label>
			<input class="form-control" id="reme" name="reme" value="<?php echo $r['reme']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="buzo">Buzos</label>
			<input class="form-control" id="buzo" name="buzo" value="<?php echo $r['buzo']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="camp">Camperas</label>
			<input class="form-control" id="camp" name="camp" value="<?php echo $r['camp']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="pant">Pantalones jogging calza short</label>
			<input class="form-control" id="pant" name="pant" value="<?php echo $r['pant']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="zapa">Zapatillas</label>
			<input class="form-control" id="zapa" name="zapa" value="<?php echo $r['zapa']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="guar">Guardapolvos</label>
			<input class="form-control" id="guar" name="guar" value="<?php echo $r['guar']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="pint">Pintorcitos</label>
			<input class="form-control" id="pint" name="pint" value="<?php echo $r['pint']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		<div class="form-group has-warning">
			<label class="label-form" for="pech">Pecheras</label>
			<input class="form-control" id="pech" name="pech" value="<?php echo $r['pech']?>" onblur="valida_0(this.id)" maxlength="10">
		</div>
		
		<input hidden name="legajo" value="<?php echo $legajo?>">

		<button class="btn-success">Guardar</button>
	</form>	
</div>	