<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Baja de apoyo en proceso de acogimiento familiar";
include("encabezado-test.php");
$id=nget("id");
$apo=un_registro("select af_apoyos.*, denominacion from af_apoyos left join af_familias on idaf_familias=familia where id=".$id);
$a=un_registro("select hogares_admision.*, apellidos, nombres, af_familias.denominacion, dispositivos.nombre from 
hogares_admision left join sujetos on sujetos.legajo=admi_legajo
left join dispositivos on admi_hogar=dispositivos.id 
left join af_familias on admi_fami=idaf_familias 
where idhogares_admision=".$apo["alojamiento"]);
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
	<div class="col-md-4">Familia de apoyo <strong><?php echo $apo["denominacion"]?></strong></div>
	<div class="col-md-4">Inicio de apoyo <strong><?php echo ffec($apo["f_desde"])?></strong></div>

</div>
<hr>
<form class="form" method="get" action="af_apoyo_baja_do" onsubmit="return valida()">
	<input hidden name="id" value="<?php echo $id?>">
	<div class="form-group has-warning">
	<label class="label-form">Fecha baja</label>
	<input class="form-control" name="f_hasta" id="f_hasta" value="<?php echo ffec($apo["f_desde"])?>" onblur="valida_fecha(this.id)" required>
	</div>	
	<div class="form-group has-warning">
         <label class="label-form">Tipo de  baja</label>
  	 <select class="form-control" id="tipobaja" name="tipobaja">
	   <option value="1">Cese</option>
	   <option value="2">Baja por error</option>
         </select>
	</div>
	<button class="btn-warning">Baja</button>
</form>
<p class="text-warning">El registro es por NNYA, se deber&aacute; registrar el nuevo apoyo en hermanos del mismo acogimiento</p>

</div>
<script>
function valida(){
 resp=ejec_sq("validadores/v_af_apoyo_baja?id=<?php echo $id?>&f_hasta="+document.getElementById("f_hasta").value+"&tipobaja="+document.getElementById("tipobaja").value);
 if(resp=="OK") return true;
 return false;
}
</script>
</body>
</html>