<?php
include("Funciones.php");
session_start();
$_SESSION['prestacion']="Alojamiento en Hogares del Circuito";
include('encabezado.php');
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: index");
registre();
$lega= $_GET["legajo"];
$tipo="";
if ($lega=="" ) Redirect("Location: consultasujetos");
if (isset($_GET["tipo"])) $tipo=$_GET["tipo"] ;
$_SESSION["posicion"]="2";
include("mnu_superior.php");
?>
<div class="container">
<h3>Historial de Alojamientos en Hogares</h3>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class="bg-primary"><td>Dispositivo</td><td>Familia</td><td>Desde</td><td>Hasta</td><td>D&iacute;as</td><td>Perm Anterior</td><td>M.Ingreso</td><td>M.Egreso</td></tr></thead>
<?php
$dt=un_registro("select * from sujetos where legajo=".$lega);
$conn=registros("select nombre as hogar, af_familias.denominacion, admi_alta, admi_baja,case when admi_baja is null then datediff(curdate(),admi_alta)+1 else permanencia end as dias , perm_anterior,ming.deno as mingre, hogares_motegreso.deno as megre,
me_pre.deno as mepre, idhogares_admision, admi_mote  
from hogares_admision left join dispositivos on dispositivos.id=admi_hogar 
left join tablas ming on ming.tipo='HOMOI' and ming.valo=admi_moti 
left join tablas hogares_motegreso on hogares_motegreso.valo=admi_mote and hogares_motegreso.tipo='HOMOE' 
left join tablas me_pre on me_pre.tipo='MEPRE' and me_pre.valo=admi_mote 
left join af_familias on admi_fami=idaf_familias 
where admi_alta is not null and admi_legajo=".$lega." order by admi_alta desc");
while ( $da = mysqli_fetch_assoc($conn)) {
  echo colorfila()."<td>".$da["hogar"]."</td><td>".$da["denominacion"]."</td><td>".ffec($da['admi_alta'])."</td><td>".ffec($da['admi_baja'])."</td><td>".$da['dias']."</td><td>".$da["perm_anterior"]."</td><td>".$da['mingre']."</td><td>".
si(intval($da["admi_mote"])<100,$da['megre'],$da["mepre"])."</td>";
  echo "</tr>";
 };
?>
</table>
</div>
<h3>Variables en relaci&oacute;n al ingreso</h3>
<form class="form-inline" method="GET" action="sujeactalojamiento">
<strong>Motivos de Ingreso</strong>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<?php  $o="<option value=0>--Seleccionar</option>".opc_tabla('MISUP');
  echo "
  <tr style='font-size:.8em;'><td>1)<select class='form-control' id='min1' name='min1'".si($_SESSION['gl_super_super']!=1," disabled","").">".$o."</select></td>
  <td>2)<select class='form-control' id='min2' name='min2'".si($_SESSION['gl_super_super']!=1," disabled","").">".$o."</select></td></tr>
  <tr style='font-size:.8em;'><td>3)<select class='form-control' id='min3' name='min3'".si($_SESSION['gl_super_super']!=1," disabled","").">".$o."</select></td></tr>
  </table></div>";
?>
<h3>Variable Contextuales</h3>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<?php
  $o="<option value=0>--Seleccionar</option>".tbla('v_contextuales');
  echo "
  <tr style='font-size:.8em;'><td>1)<select  class='form-control' id='ctx1' name='ctx1'".si($_SESSION['gl_super_super']!=1," disabled","").">".$o."</select></td>
  <td>2)<select  class='form-control' id='ctx2' name='ctx2'".si($_SESSION['gl_super_super']!=1," disabled","").">".$o."</select></td>
  <td>3)<select  class='form-control' id='ctx3' name='ctx3'".si($_SESSION['gl_super_super']!=1," disabled","").">".$o."</select></td></tr>
  </table></div>";
?>
<script>
seleccionar("min1","<?php echo $dt['ming1'];?>");
seleccionar("min2","<?php echo $dt['ming2'];?>");
seleccionar("min3","<?php echo $dt['ming3'];?>");
seleccionar("ctx1","<?php echo $dt['ctex1'];?>");
seleccionar("ctx2","<?php echo $dt['ctex2'];?>");
seleccionar("ctx3","<?php echo $dt['ctex3'];?>");
</script>
<input name="legajo" type="hidden" value="<?php echo $lega;?>">
<?php if($_SESSION['gl_super_super']==1) echo "<input class='btn-success' type='submit' value='Actualizar Variables'>";?>
</form>
<h3>Estados y Acciones relacionados con la Estrategia de Egreso</h3>
<div class="table-responsive pre-scrollable">
<table class="table">
<thead>
<tr class="bg-primary"><th>Fecha</th><th>Estrategia</th><th>Estado</th><th>Acciones</th><th>Usuario</th></tr>
</thead>
<?php
$reg=registros("select sujetos_estrategias.*, t1.deno as estra, t2.deno as esta  from sujetos_estrategias left join tablas t1 on t1.tipo='EE' and t1.valo=estrategia left join tablas t2 on t2.tipo='ETEE' and t2.valo=estado where legajo=".$lega." order by fecha desc, idsujetos_estrategias desc");
while($r=mysqli_fetch_assoc($reg)){
echo "<tr><td>".ffec($r["fecha"])."</td><td>".$r["estra"]."</td><td>".$r["esta"]."</td><td>".$r["acciones"]."</td><td>".$r["usuario"]."</td></tr>";
};
?>
</table>
</div>
<?php if($_SESSION["gldispo"]==2||$_SESSION["gldispo"]==13||$_SESSION["gldispo"]==12||$_SESSION["gldispo"]==34||$_SESSION["gldispo"]==37||un_campo("select hogar from sectores where id=".$_SESSION["gldispo"])>"0"){
echo "<button class='btn-primary' onclick='act_estra()'>Actualizar Estrategia</button><br><br>";};?>
</div>
<script>
function act_estra(){
 navega("actualizacion_estrategia?legajo=<?php echo $lega?>");
 return true;
}
</script>
</body>
</html>