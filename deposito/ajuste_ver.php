<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Ver un Ajuste";
include("encabezado-test.php"); 
$id=nget("id");
?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-striped table-bordered">
<thead>
<tr class='bg-primary'><th>Ajuste</th><th>Motivo</th><th>Fecha</th></tr>
</thead>
<?php $r=un_registro("select *  from ajustes  where idajustes=".$id); 
echo "<tr><td>".$id."</td><td>".$r["motivo"]."</td><td>".ffec($r["fecha"])."</td></tr>";?>
</table>
</div>
</div>
<div class="container">
<div class="table-responsive">
<table id='articulos' class="table table-striped table-bordered">
<thead>
<tr class='bg-primary'><th>Art&iacuteculo</th><th>Cantidad</th></tr>
</thead>
<?php 
  $reg=registros("select descripcion,cantidad from ajustes_articulos left join articulos on articulo=idarticulos where ajuste=".$id);
  while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["descripcion"]."</td><td align='center'>".$r["cantidad"]."</td></tr>";
  };
?>
</table>
</div>
<?php echo "<button class='btn-primary' onclick=navega('ajustes_consulta')>Volver a Consulta</button>"?>
</div>
<script>
function exhibe(){
   tabla=document.getElementById("articulos");
   tabla.resize;
}
exhibe();

function subir(id){
navega("archivo_subir?tipo=COMPR&id="+id+"&referencia=AJU "+numero+"&retorno=ajuste_ver");
}
function descargar(id){
navega("archivo_descarga?id="+id);
}

</script>
</body>