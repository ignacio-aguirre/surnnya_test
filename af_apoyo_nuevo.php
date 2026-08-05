<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Nuevo apoyo en proceso de acogimiento familiar";
include("encabezado.php");
$id=nget("id");
$a=un_registro("select hogares_admision.*, apellidos, nombres, af_familias.denominacion, dispositivos.nombre from 
hogares_admision left join sujetos on sujetos.legajo=admi_legajo
left join dispositivos on admi_hogar=dispositivos.id 
left join af_familias on admi_fami=idaf_familias 
where idhogares_admision=".$id);
$fam=registros("select idaf_familias, denominacion from af_familias 
	where hogar=".$a["admi_hogar"]." and idaf_familias<>".$a["admi_fami"]." and estado1=1 and fecha_baja is null and idaf_familias not in 
 (select distinct familia from af_apoyos where alojamiento=".$id." and f_hasta is null)");
$opc_fam="";
while($f=mysqli_fetch_assoc($fam)){
$opc_fam=$opc_fam."<option value='".$f["idaf_familias"]."'>".$f["denominacion"]."</option>";
}
?>
</div>
<div class="container">
<div class="row">
	<div class="col-md-4">NNyA  <strong><?php echo $a["apellidos"].", ".$a["nombres"]?></strong></div>
	<div class="col-md-4">En familia <strong><?php echo  $a["denominacion"]?></strong></div>
	<div class="col-md-4">Dispositivo <strong><?php echo  $a["nombre"]?></strong></div>
</div>
<div class="row">
	<div class="col-md-4">F.inicio acogimiento <strong><?php echo ffec($a["admi_alta"])?></strong></div>
	<div class="col-md-4"></div>
</div>
<hr>
<form class="form" method="get" action="af_apoyo_nuevo_do" onsubmit="return valida()">
	<input hidden name="alojamiento" value="<?php echo $id?>">
	<div class="form-group has-warning">
	<label class="label-form">Nueva familia de apoyo</label>
	<select class="form-control" name="familia"><?php echo $opc_fam?></select>
	</div>	
	<div class="form-group has-warning">
	<label class="label-form">Fecha inicio</label>
	<input class="form-control" name="f_desde" id="f_desde" value="<?php echo ffec($a["admi_alta"])?>" onblur="valida_fecha(this.id)">
	</div>	
	<button class="btn-success">Ingresar</button>
</form>
<p class="text-warning">El registro es por NNYA, se deber&aacute; registrar el nuevo apoyo en hermanos del mismo acogimiento</p>

</div>
<script>
function valida(){
 return true;
}
</script>
</body>
</html>