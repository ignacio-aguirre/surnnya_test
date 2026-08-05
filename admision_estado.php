<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Cambio de Estado de Pedido de Recurso";
include("encabezado-test.php");
registre();
$id=$_GET["id"];
$pedido=un_registro("select * from hogares_admision where idhogares_admision=".$id);
$estado_anterior=un_registro("select * from ad_pedidos_estados where vacante=".$id." order by fecha desc, id desc limit 1");
?>
<div class="container">
<h4>Cambio de estado del pedido de recurso para <?php echo un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$pedido["admi_legajo"])?></h4>
<form class="form-inline" method="get" action="admision_estado_do" onsubmit="return valida()">

  <div class="form-group has-warning">
	<label class="label-form">Fecha de &uacute;ltimo estado&nbsp;</label>
	<input class="form-control" id="fecha_anterior" disabled size="10" maxlength="10" value="<?php echo ffec($estado_anterior["fecha"])?>">
  </div> 
  <div class="form-group has-warning">
	<label class="label-form">&nbsp;Usuario&nbsp;</label>
	<input class="form-control" disabled size="60" maxlength="60" value="<?php echo $estado_anterior["usuario"]?>">
  </div> 
<br><br>
  <div class="form-group has-warning">
	<label class="label-form">Estado Actual&nbsp;</label>
	<input class="form-control" disabled size="50" maxlength="50" value="<?php echo un_campo("select deno from tablas where tipo='ADEV' and valo=".nulea($estado_anterior["estado"]))?>">
  </div> 
  <div class="form-group has-warning">
	<label class="label-form">&nbsp;Hogar Articulaci&oacute;n Anterior &nbsp;</label>
	<input class="form-control" disabled id="hogar_anterior" size="40" maxlength="40" value="<?php echo un_campo("select nombre from dispositivos where id=".nulea($estado_anterior["hogar"]))?>">
  </div> 
<br><br>
  <div class="form-group has-warning">
	<label class="label-form">Nuevo Estado&nbsp;</label>
	<select class="form-control" id="estado" name="estado" autofocus><?php echo opc_tablav("ADEV")?></select>
  </div> 
  <div class="form-group has-warning">
	<label class="label-form">&nbsp;Fecha del cambio&nbsp;</label>
	<input class="form-control" id="fecha" name="fecha" size="10" maxlength="10" value="<?php echo $_SESSION["DiaHoy"]?>" onblur="valida_fecha(this.id)">
  </div> 
<br><br>
  <div class="form-group has-warning">
	<label class="label-form">Motivo del Cambio&nbsp;</label>
	<input class="form-control" id="motivo_cambio" name="motivo_cambio" size="60" maxlength="60">
  </div>
<br><br>
  <div class="form-group has-warning">
	<label class="label-form">Hogar Articulaci&oacute;n</label>
	<select class="form-control" id="hogar" name="hogar"><?php echo str_replace("Completar","Ninguno",$_SESSION["Opc_Hoga"])?></select>
	<script>seleccionar("hogar","<?php echo $pedido["admi_hogar"]?>");</script>
  </div> 
<br><br>
 <input hidden name="id" value="<?php echo $id?>">
 <button type="submit" class="btn btn-primary">Cambiar</button>
</form>
<script>
function valida(){
 valida_fecha("fecha");
 campo_fecha=document.getElementById("fecha").value;
 hoy="<?php echo $_SESSION["DiaHoy"]?>";
 anterior=document.getElementById("fecha_anterior").value;
 pedido="<?php echo ffec($pedido["admi_fped"])?>";
 if(campo_fecha==""){alert("fecha es obligatoria");return false;};
 if(fsql(campo_fecha)>fsql(hoy)){alert("fecha no puede ser futura");return false;};
 if(anterior==""){
   if(fsql(campo_fecha)<fsql(pedido)){alert("fecha no puede ser anterior a la del pedido");return false;};
   } else{
       if(fsql(campo_fecha)<fsql(anterior)){alert("fecha no puede ser anterior a la del estado anterior");return false;};
  };
 hogar_anterior="<?php echo $estado_anterior["hogar"]?>";
 if(hogar_anterior=="") {hogar_anterior="0";};
 estado_anterior="<?php echo $estado_anterior["estado"]?>";
 if(estado_anterior=="") {estado_anterior="0";};
 campo_estado=document.getElementById("estado").value;
 campo_hogar=document.getElementById("hogar").value;
 if(campo_hogar==""){campo_hogar="0";};
 if(hogar_anterior==campo_hogar && estado_anterior==campo_estado){alert("No hay cambios");return false;};
 return true;
}
</script>
<h3>Historial de cambios de estado</h3>
<div class="table-responsive">
<table class="table-condensed">
<tr class="bg-primary text-white"><th>Fecha</th><th>Estado</th><th>Hogar</th><th>Motivo Fin</th><th>Usuario</th></tr>
<?php $reg=registros("select * from ad_pedidos_estados 
 left join dispositivos on hogar=dispositivos.id 
 left join tablas on tablas.tipo='ADEV' and tablas.valo=estado where vacante=".$id." order by fecha desc, ad_pedidos_estados.id desc");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".ffec($r["fecha"])."</td><td>".$r["deno"]."</td><td>".$r["nombre"]."</td><td>".$r["motivo_cambio"]."</td><td>".$r["usuario"]."</td></tr>";
 };
?>
</table>
</div>
</div>
</body>