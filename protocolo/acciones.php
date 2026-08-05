<?php 
include("funciones.php");
session_start();
$_SESSION["titulo"]="Acciones";
tranca();
include("encabezado-test.php");
$id=$_SESSION["caso"];
$nya=un_campo("select concat(apellidos,', ',nombres) from casos where idcasos=".$id);
$filtro="";
if(isset($_GET["filtro"])){
 $filtro=$_GET["filtro"];
}
?>
<div class="container" align="center">
<h4>Historial de acciones legajo <?php echo $nya?></h4>
</div>

</div>
<div class="container">
<div class="table-responsive pre-scrollable" style="max-height: 420px;">
<table class="table table-bordered">
<tr class="table-primary">
<th class="col-md-2">Fecha</th><th class="col-md-2">Organismo</th><th>Origen</th><th class="col-md-8">Detalle</th>
</tr>
<?php
$sql="select * from acciones left join usuarios on usuario=idusuarios where caso=".$id." and fecha_baja is null";
if($filtro!=""){$sql=$sql." and origen=".$filtro;};
$sql=$sql." order by fecha desc, id desc ";

$nov=registros($sql);
$origenes=array("","CDNNYA","DCAlt","Jpenal","Jcivil","PSA","Salud");
$clases=array("table-dark","table-danger","table-warning","table-success","table-light","table-secondary","table-info");
while($n=mysqli_fetch_assoc($nov)){
	$ori=$origenes[$n["origen"]];
	$cla=$clases[$n["origen"]];
 
 echo "<tr class='".$cla."' style='font-size:.9em'><td>".ffec($n["fecha"]). "</td><td>",$n["reparticion"]."-".$n["sector"]."</td><td>".$ori."</td><td>".$n["descripcion"]." ".
 si($n["usuario"]==$_SESSION["usuario"],"<img src='imagenes/eliminar.png' height='15' width='15' onclick='elimina(".$n["id"].")'>","")."</td></tr>"; 
 
};
?>
</table>
</div>
<br><br>
<?php if($_SESSION["escritura"]=="1"){?>
	<button class="btn-sm btn-info" onclick='navega("accion_nueva")'>Registrar nueva</button>
<?php }?>
<button class="btn-sm btn-primary" onclick='navega("uncaso")'>Legajo</button>
<button class="btn-sm btn-success" onclick='navega("documentacion")'>Documentaci&oacute;n</button>
<button class="btn-sm btn-secondary" onclick="navega('casos')">casos</button>

<hr>
<h4>Gu&iacute;a filtros por colores</h4>
<div class="table-responsive pre-scrollable" style="max-height: 420px;">
<table class="table  table-bordered ">
<?php 
for($i=0;$i<=6;$i++){
 $ori=$origenes[$i];
 $cla=$clases[$i];
 $okl=" onclick='filtra(".$i.")'";
 if($ori==""){$ori="No clasificado";
$okl="";};
  echo "<tr".$okl." class='".$cla."' style='font-size:.9em'><td>".$ori."</td></tr>";
}
?>
</table>
</div>

<script>
function elimina(id){
if(confirm("Confirma que desea eliminar el item?")) navega("eliminarnovedad?id="+id);
}	
function filtra(i){
  navega("acciones?filtro="+i);
}

</script>
</div>