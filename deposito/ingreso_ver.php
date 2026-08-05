<?php 
include("funciones.php");
session_start();
$id=$_GET["id"];
$_SESSION["prestacion"]="Consultar Ingreso de Bienes";
include("encabezado.php"); 
?>
<div class="container">
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class='bg-primary'><th>Id</th><th>Origen</th><th>Fecha</th><th>Observaciones</th></tr></thead>
<tbody><?php $r=un_registro("select *  from ingresos where idingresos=".$id); 
echo "<tr><td>".$r["idingresos"]."</td><td>".morig($r["origen"])."</td><td>".ffec($r["fecha"])."</td><td>".
$r["observaciones"]."</td></tr>";
function morig($o){
 if($o=="P") return "Proveedor";
 if($o=="D") return "Otro Depo";
 if($o=="E") return "Dev.Efector";

}

?>
</tbody></table>
</div>
</div>
<div class="container">
<div class="table-responsive pre-scrollable">
<table id='articulos' class="table table-bordered table-striped table-condensed">
<thead><tr class='bg-primary'><th>Art&iacute;culo</th><th>Cantidad</th></tr></thead>
<tbody>
<?php 
  $reg=registros("select * from ingresos_articulos left join articulos on ingresos_articulos.articulo=idarticulos where ingreso=".$id);
  while($r=mysqli_fetch_assoc($reg)){
  echo "<tr style=><td>".$r["descripcion"]."</td><td>".$r["cantidad"]."</td></tr>";
  };
?>
</tbody>
</table>
</div>
</div>
</div>
</body>