<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Nueva Tarea";
include("encabezado-test.php");
$id=nget("id");
$r=un_registro("select * from lunna_activos where id=".$id);
?>
</div>
<div class="container">
<h3><?php echo $r["nombre"]?></h3>
<div class="row">
 <div class="col-md-4">CUIL <p class="text-primary"><strong><?php echo $r["cuil"]?></strong></p></div>
 <div class="col-md-4">Usuario SADE <p class="text-primary"><strong><?php echo $r["usuario"]?></strong></p></div>
 <div class="col-md-4">Email <p class="text-primary"><strong><?php echo $r["mail"]?></strong></p></div>
</div>
<hr>
<div class="row">
 <div class="col-md-4">Repartici&oacute;n <p class="text-primary"><strong><?php echo $r["reparticion"]?></strong></p></div>
 <div class="col-md-4">Sector <p class="text-primary"><strong><?php echo $r["sector"]?></strong></p></div>
 <div class="col-md-4">Perfil LUNNA <p class="text-primary"><strong><?php echo $r["perfil"]?></strong></p></div>
</div>
<h3>Multi reparticiones</h3>
A desarrollar
<h3>Detalle de la tarea a realizar</h3>
<form class="form-inline">
        <div class="row">
	<div class="form-group has-warning mb-2">
	  <label class="col-form-label col-md-4">Fecha de Ingreso&nbsp;&nbsp;&nbsp;</label>
	  <div class="col-md-4">
	  <input class="form-control" size="10" maxlength="10" id="fecha_ingreso" name="fecha_ingreso" onblur="valida_fecha(this.id)" required autofocus>
	  </div>
        </div>
	<div class="form-group has-warning mb-2">
	  <label class="col-form-label col-md-4">Tipo de Tarea&nbsp;&nbsp;&nbsp;</label>
	  <div class="col-md-4">
	  <?php echo select_tabla("tipo_tarea","LNTT",true,false)?>
	  </div>
        </div>
	<div class="form-group has-warning mb-2">
	  <label class="col-form-label col-md-4">Origen del Pedido&nbsp;&nbsp;&nbsp;</label>
	  <div class="col-md-4">
	 
	  <?php echo select_tabla("origen_pedido","LNOP",true,false)?> 
	  </div>
        </div>
        </div><br><br>
        <div class="row">
	<div class="form-group has-warning mb-2">
	  <label class="col-form-label col-md-4">Perfiles&nbsp;&nbsp;</label>
	  <div class="col-md-4">
	  <select class="form-control" id="nuevo_perfil" name="nuevo_perfil" required>
           <option value="0">NO</option>
           <option value="1">1</option>
           <option value="2">2</option>
           <option value="3">3</option>
           <option value="4">4</option>
           <option value="9">Quitar</option>
          </select>
	  </div>
        </div>
	<div class="form-group has-warning mb-2">
	  <label class="col-form-label col-md-4">Multi Rep&nbsp;&nbsp;</label>
	  <div class="col-md-4">
	  <select class="form-control" id="gestion_multi_repa" name="gestion_multi_repa" required>
           <option value=""></option>
           <option value="0">NO</option>
           <option value="1">Agregar</option>
           <option value="2">Quitar</option>
          </select>
	  </div>
        </div>
      	<div class="form-group has-warning mb-2">
	  <label class="col-form-label col-md-4">Detalles adicionales</label>
	  <div class="col-md-4">
		<input class="form-control" id="detalles" name="detalles" size="30" maxlength="100">
	  </div>
        </div>
        </div>
        <hr>
	<div class="form-group row has-warning">
	  <button class="btn-primary">Registrar</button>
        </div>
</form>
</div>
</body>
</html>