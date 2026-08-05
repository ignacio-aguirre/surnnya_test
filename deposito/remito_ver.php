<?php 
include("funciones.php");
session_start();
tranca();
$status="";
if(isset($_GET["id"])){ $_SESSION["id"]=$_GET["id"];$_SESSION["recibir"]=si(isset($_GET["recibir"]),1,0);Redirect("remito_ver");};
$id=$_SESSION["id"];
$recibir=$_SESSION["recibir"];
$_SESSION["recibir"]=0;
$_SESSION["prestacion"]=si($recibir==1,"Recibir Remito de Entrega","Consultar Remito de Entrega");
include("encabezado.php"); 
?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-striped table-bordered">
<thead><tr class='bg-primary' style='font-size:.8em; display:inline-table height:22px;'><th>RME Nro.</th><th>Efector</th><th>Fecha</th><th>Pedido</th><th>Usuario</th><th>Estado</th><th>Archivo</tr></tr></thead>
<tbody><?php $r=un_registro("select idcomprobantes,comprobantes.baja,numero,efectores.descripcion as enti, fecha, pedido, concat(u1.apellido,', ',u1.nombre) as usua, estado
  from comprobantes left join efectores on entidad=idefectores left join usuarios u1 on usuario=u1.idusuarios left join remitos on remitos.comprobante=idcomprobantes where idcomprobantes=".$id); 
echo "<tr style='font-size:.8em; height:22px;'><td>".$r["numero"]."</td><td>".$r["enti"]."</td><td>".ffec($r["fecha"])."</td><td>".un_campo("select idpedidos from pedidos where comprobante=".$r["pedido"])."</td><td>".$r["usua"]."</td><td>".si($r["baja"]=="",si($r["estado"]=="1","EMITIDO","ENTREGADO"),"ANULADO ".ffec($r["baja"])).
"</td><td>".si($r["archivo"]==0,"<button class='btn-secondary' style='height:20px;' onclick='subir(".$r["idcomprobantes"].",".$r["numero"].")'>Subir</button>","<img src='imagenes/pdf-icon.png' height='20' width='20' onclick='descargar(".$r["archivo"].")'>")."</td></tr>";
$pedido=$r["pedido"];
$baja=$r["baja"];
$estado=$r["estado"]?>
</tbody></table>
</div>
</div>
<div class="container">
<div class="table-responsive">
<table id='articulos' class="table table-bordered table-striped table-condensed">
<thead><tr class='bg-primary '><th>Reng</th><th>Art&iacuteculo</th><th>Cantidad</th></tr></thead>
<tbody>
<?php 
  $vtot=0;
  $reg=registros("select renglon,articulo,descripcion,cantidad,cantidad*precio as valor from remitos_articulos pa1 left join articulos on pa1.articulo=idarticulos where pa1.comprobante=".$id);
  while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["renglon"]."</td><td>".$r["descripcion"]."</td><td>".$r["cantidad"]."</td></tr>";
 };
?>
</tbody>
</table>
</div> 
<?php if($recibir==0 && $_SESSION["remi"]==1 && $baja=="" && $estado==1) echo "<button class='btn-primary' id='mas' onclick='anula(".$id.")'>Anular</button>&nbsp;";?>
<?php if($recibir==1 && $estado==1) {
  echo "<div class='table-responsive'>";
  echo "Indic&aacute; Fecha de Recepci&oacute;n y hac&eacute; clic en Recibir para registrar que este remito fue recibido en el efector";
  echo "<table class='table table-bordered table-condensed'>";
  echo "<tr class='bg-primary' style='font-size:.8em; display:inline-table height:22px;'><th>Fecha Recibido</th><th></th></tr>";
  echo "<tr style='font-size:.8em; height:22px;'><td><input id='fecha_recibido' size='8' maxlength='10' onblur='valida_fecha(this.id)'></td><td>".
   "<button class='btn-primary' onclick='recibir(".$id.",".$pedido.")'>Recibir</button></td></tr>";
  };
?>
</div>
</div>
<script>
document.getElementById("fecha_recibido").focus();
function anula(id){
if(confirm("desea anular el remito?"))
 if(confirm("está seguro?")){
   comprobante=id;
   id_sem=semaforo_pone();
   ejec("ej_remitos","ANULAR","&comprobante="+comprobante+"&pedido="+"<?php echo $pedido;?>");
   semaforo_saca(id_sem);
   navega("remitos_consulta?status=remito anulado");
 };
};
function recibir(id,pedido){
 valida_fecha("fecha_recibido");
 frec=document.getElementById("fecha_recibido").value;
 if(frec=="") return false;
 comprobante=id;
 id_sem=semaforo_pone();
 ejec("ej_remitos","RECIBIR","&comprobante="+comprobante+"&pedido="+pedido+"&fecha_recibido="+frec);
   semaforo_saca(id_sem);
   navega("remitos_consulta");
}; 

function subir(id,numero,nombre){
navega("archivo_subir?tipo=COMPR&id="+id+"&referencia=RMC "+numero+" "+"<?php echo $nombre;?>"+"&retorno=rprov_ver");
}

function descargar(id){
navega("archivo_descarga?id="+id);
}
</script>
</body>