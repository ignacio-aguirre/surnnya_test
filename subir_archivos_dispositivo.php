<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
$dispositivo=$_SESSION["gldispo"];
if(isset($_GET["dispositivo"])) $dispositivo=$_GET["dispositivo"];  
?>
<div class="container">
<?php 
if( $_SESSION['gl_todos_dispo']==1) echo "<form class='form'>Dispositivo<select class='form-control' name='dispo' id='dispo' onchange=navegadispo(this.id)>".$_SESSION['Opc_dispo']."</select></form>";
?>
<script type="text/javascript">
function navegadispo(id){
navega("subir_archivos_dispositivo?dispositivo="+document.getElementById(id).value);
}</script>
<h2>Archivos Vinculados al dispositivo <?php echo un_campo("select denominacion from sectores where id=".$dispositivo)?> </h2>
<br>
Subir Nuevo <a href="subir_archivos?dispositivo=<?php echo $dispositivo;?>">Archivo</a><br>
<div class="table-responsive">
<table class="table">
<tr><th>Tipo</th><th>Descripci&oacute;n</th><th>Efector - Usuario</th><th>Fecha Subida</th><th>Acciones</th>
<?php 
  $sql="select deno,restringido,as_descripcion, concat(denominacion,'-',as_usuario) as efector, as_fecha as fecha, as_path,
  as_dispositivo, as_usuario, idarchivos_subidos as id 
  from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo 
  left join tablas on tablas.tipo='TA' and tablas.valo=as_tipo 
  where archivos_vinculos.tipo='D' and identificador=".$dispositivo." and as_baja is null 
  order by as_tipo, as_fecha desc";
  $conn = registros($sql);
   while ($da = mysqli_fetch_assoc($conn)) {
    if($da["restringido"]==0||$_SESSION["menu"]=="menusys") {
     echo colorfila()."<td>".$da['deno']."</td><td>".$da['as_descripcion']."</td><td>".$da['efector']."</td><td>".ffec($da['fecha'])."</td><td><a href='descarga?link=".sacamas($da['as_path'])."&nombre=".sacamas_limpia(sacapath($da['as_path']))."'>Descargar</a>";
     if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) echo "<a href='archdesvincular?id=".$da['id']."&tipo=D&identificador=".$dispositivo."'> Desvincular</a>";
     echo "</td></tr>";
    };
   };
?>
</table>
</div>
</div>

<script type="text/javascript">

seleccionar("dispo","<?php echo $dispositivo;?>")

</script>

</body>

</html>