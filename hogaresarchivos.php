<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Documentos Asociados a Hogares";
include("encabezado-test.php");
$retorno=$_SESSION["menu"];
$id=$_GET["id"];
$da = un_registro("select * from dispositivos where dispositivos.id=".$id);
$tipo="";
if (isset($_GET["tipo"])) $tipo=$_GET["tipo"] ;
?>
<div class="container">
Subir Nuevo <a href="subir_archivos?hogar=<?php echo $id;?>">Archivo</a>
<h2>Cantidades de Archivos Vinculados<h2>
<div class="table-responsive pre-scrollable">
<table class="table">
<tr><td>Tipo</td><td>Cant.</td><td>Acciones</td></tr>
<?php 
 $sql="select deno,restringido,as_tipo, count(*) as cant from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos  
 left join tablas on tablas.tipo='TA' and valo=as_tipo where archivos_vinculos.tipo='H' and identificador=".$id." and as_baja is null
 group by deno,restringido,as_tipo order by deno ";
 $conn = registros($sql);
 while ($da = mysqli_fetch_assoc($conn)) {
  if($da["restringido"]==0||$_SESSION["menu"]=="menusys"){
   echo colorfila()."<td>".$da['deno']."</td><td>".$da['cant']."</td><td><a href='hogaresarchivos?id=".$id."&tipo=".$da["as_tipo"]."'>Ver</a></td></tr>";
  };
};
?>
</table>
</div>

<h2>Archivos Vinculados</h2>
<div class="table-responsive pre-scrollable">
<table class="table">
<tr><td>Tipo</td><td>Descripci&oacute;n</td><td>Efector - Usuario</td><td>Fecha Subida</td><td>Acciones</td></tr>
<?php 
 if($tipo!="") {
  $sql="select deno,restringido,as_descripcion, concat(denominacion,'-',as_usuario) as efector, as_fecha as fecha, as_path,
  as_dispositivo, as_usuario, idarchivos_subidos as id 
  from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo 
  left join tablas on tablas.tipo='TA' and tablas.valo=as_tipo 
  where archivos_vinculos.tipo='H' and identificador=".$id." and as_tipo=".$tipo." and as_baja is null 
  order by as_tipo, as_fecha desc";
  $conn = registros($sql);
  while ($da = mysqli_fetch_assoc($conn)) {
    if($da["restringido"]==0||$_SESSION["menu"]=="menusys") {
     echo colorfila()."<td>".$da['deno']."</td><td>".$da['as_descripcion']."</td><td>".$da['efector']."</td><td>".ffec($da['fecha'])."</td><td><a href='descarga?link=".sacamas($da['as_path'])."&nombre=".sacamas_limpia(sacapath($da['as_path']))."'>Descargar</a>";
     if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) echo "<a href='archdesvincular?id=".$da['id']."&tipo=H&identificador=".$id."'> Desvincular</a>";
     echo "</td></tr>";
    };
   };
  };
?>
</table>
</div>
</div>
<script type="text/javascript">

function valida_arch() {

if(document.getElementById("descr").value=="") return false;

return true;

}

</script>



</body>

</html>