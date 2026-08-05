<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Apoyos en proceso de acogimiento familiar";
include("encabezado-test.php");
$id=nget("id");
$a=un_registro("select hogares_admision.*, apellidos, nombres, af_familias.denominacion, dispositivos.nombre from 
hogares_admision left join sujetos on sujetos.legajo=admi_legajo
left join dispositivos on admi_hogar=dispositivos.id 
left join af_familias on admi_fami=idaf_familias 
where idhogares_admision=".$id);
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
	<div class="col-md-4"><button class="btn-success" onclick="nuevo(<?php echo $id?>)">Nueva familia de apoyo</button></div>
</div>
<h4>Familias de apoyo</h4>
<div class="table-responsive">
<table class="table">
	<tr class="bg-success" style="font-size:.9em"><th>Familia de apoyo</th><th>Desde</th><th>Hasta</th><th>Opciones</th></tr>
<?php
 $apo=registros("select id,denominacion, f_desde, f_hasta from af_apoyos left join af_familias on idaf_familias=familia where alojamiento=".$id." order by f_desde desc");
 while($y=mysqli_fetch_assoc($apo)){
	echo "<tr style='font-size:.9em'><td>".$y["denominacion"]."</td><td>".ffec($y["f_desde"])."</td><td>".ffec($y["f_hasta"]).
	"</td><td><button class='btn-sm btn-danger' onclick='baja(".$y["id"].")'>Baja</button></td></tr>";

 }
?>
</table>
</div>
</div>

<script>
function nuevo(id){
 navega("af_apoyo_nuevo?id="+id);
}
function baja(id){
 navega("af_apoyo_baja?id="+id);
}
</script>
</body>
</html>