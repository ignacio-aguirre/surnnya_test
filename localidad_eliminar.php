<?php 
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Eliminar localidad";
include("encabezado.php");
$id=nget("id");
$l=un_registro("select localidades_nueva.*, paises.descripcion as npais from localidades_nueva left join paises on pais=idpaises where id=".$id);
?>
</div>
<div class="container">

<form class="form-inline" action="localidad_eliminar_do" method="post" >
	<input hidden name="id" value="<?php echo $id?>">
        <div class="row">
	<div class="form-group has-warning col-md-4">
	  <label class="label-form">Pa&iacute;s</label>
	   <input class="form-control"  value="<?php echo $l['npais']?>">
	</div>
	<div class="form-group has-warning col-md-3">
	  <label class="label-form">Provincia</label>
	   <input class="form-control" readonly value="<?php echo $l['provincia']?>">
	</div>
	</div>
        <div class="row">
	<br>
	</div>
        <div class="row">
	  <div class="form-group has-warning col-md-3">
	    <label class="label-form">Nombre de la localidad</label>
	       <input class="form-control" value="<?php echo $l['nombre']?>">
	</div>	
	<div class="form-group has-warning col-md-3">
	  <label class="label-form">Partido</label>
	   <input class="form-control" value="<?php echo $l['partido']?>">
	</div>
	
      </div>
      <div class="row">	
	<hr class="md-col-12">	
       </div>		
      <div class="row">	
	<div class="form-group has-warning col-md-6">
      		<button class="btn btn-danger">Eliminar</button>
        </div>
      </div> 		
</form>
</div>
</div>