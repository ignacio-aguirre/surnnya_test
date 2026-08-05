<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Dispositivos Vinculados a la ONG";
include("encabezado.php");
$id=$_GET["id"];
?>
</div>
<div class="container">
<h3><?php echo un_campo("select nombre from hogares_ong where id=".$id)?></h3>
Registrar Nuevo <a href="un_dispositivo?id=0&ong=<?php echo $id;?>">Dispositivo</a><br>
<h3>Dispositivos Vinculados</h3>
<div class="table-responsive pre-scrollable">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class='bg-primary' style='font-size:.80em;'><th>Tipo Dispositivo</th><th>Nombre</th><th>Domicilio</th><th>Tel&eacute;fonos</th><th>Email</th><th>Estado</th><th>Acciones</th></tr></thead>
<tbody id='cuerpo'>
 <?php
  $reg=registros("select dispositivos.*, tablas.deno as dtip from dispositivos left join tablas on tablas.tipo='DITIP' and valo=tipo_dispositivo where ong=".$id." and baja_sistema is null");
  while($r=mysqli_fetch_assoc($reg)){
   echo "<tr style='font-size:.80em;'><td>".$r["dtip"]."</td><td>".$r["nombre"]."</td><td>".$r["domicilio"]." ".$r["localidad"]."</td><td>".$r["telefonos"]."</td><td>".$r["email"]."</td><td>".si(ffec($r["baja"])=="","Alta","Baja")."</td><td><button class='btn-small btn-warning' onclick='ver(".$r["id"].")'>Ver</button>&nbsp;&nbsp;
<button class='btn-small btn-primary' onclick='editar(".$r["id"].")'>Editar</button>&nbsp;&nbsp;
<button class='btn-small btn-info' onclick='archivos(".$r["id"].")'>Documentaci&oacute;n</button></td></tr>";
  };
 ?>
</tbody>
</table>
</div>
<script>
function editar(id){
navega("un_dispositivo?id="+id);
}
function ver(id){
naveganuevo("dispositivos_ver?id="+id);
}
function archivos(id){
navega("dispositivos_archivos?id="+id);
}

</script>
</body>
</html>