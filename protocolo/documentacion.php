<?php 
include("funciones.php");
session_start();
$_SESSION["titulo"]="Documentaci&oacute;n";
tranca();
include("encabezado-test.php");
$id=$_SESSION["caso"];
$nya=un_campo("select concat(apellidos,', ',nombres) from casos where idcasos=".$id);
$filtro="";
if(isset($_GET["filtro"])){
 $filtro=$_GET["filtro"];
}?>
<div class="container" align="center">
<h4>Historial de documentos legajo <?php echo $nya?></h4>
</div>
<div class="container">

</div>
<div class="container">
<div class="table-responsive pre-scrollable" style="max-height: 420px;">
<table class="table  table-bordered ">
<tr class="table-primary">
<th class="col-md-2">Fecha</th><th class="col-md-2">Organismo</th><th>Origen</th><th class="col-md-6">Documento</th><th>Eliminar</th></tr>
<?php
$sql="select * from archivos left join usuarios on usuario=idusuarios where caso=".$id." and fecha_baja is null ";
if($filtro!=""){$sql=$sql." and origen=".$filtro;};
$sql=$sql." order by fecha desc, idarchivos desc ";
$nov=registros($sql);
$origenes=array("","CDNNYA","DCAlt","Jpenal","Jcivil","PSA","Salud");
$clases=array("table-dark","table-danger","table-warning","table-success","table-light","table-secondary","table-info");
while($n=mysqli_fetch_assoc($nov)){
 $ori=$origenes[$n["origen"]];
 $cla=$clases[$n["origen"]];
 echo "<tr class='".$cla."' style='font-size:.9em'><td>".ffec($n["fecha"]). "</td><td>".$n["reparticion"]."-".$n["sector"]."</td><td>".$ori."</td><td onclick='descarga(".'"'.$n["ruta"].'"'.")'><img src='imagenes/pdf-icon.png' height='25' width='25'>".$n["descripcion"]."</td><td>".
 si($n["usuario"]==$_SESSION["usuario"],"<img src='imagenes/eliminar.png' height='15' width='15' onclick='elimina(".$n["idarchivos"].")'>","")."</td></tr>"; 
 
};
?>
</table>
</div>
<hr>
<?php if($_SESSION["escritura"]=="1"){?>


<button class="btn-sm btn-info" onclick='navega("documento_nuevo")'>Subir nuevo</button>
<?php }?>
<button class="btn-sm btn-primary" onclick='navega("uncaso")'>Legajo</button>
<button class="btn-sm btn-success" onclick='navega("acciones")'>Acciones</button>
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
  echo "<tr ".$okl." class='".$cla."' style='font-size:.9em'><td>".$ori."</td></tr>";
}
?>
</table>
</div>
<script>
function elimina(idarchivo){
if(confirm("Confirma que desea eliminar el item?")) {navega("eliminararchivo?id="+idarchivo);
};	
}

function descarga(url){ 
 window.open(url);
 return true;
}
function filtra(i){
  navega("documentacion?filtro="+i);
}
</script>	


</script>
</div>