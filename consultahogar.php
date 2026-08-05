<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
$_SESSION["prestacion"]="Acciones y Archivos del Hogar ".un_campo("select nombre from dispositivos where dispositivos.id=".$id);
include("encabezado-test.php");
if (!isset($_SESSION["gldispo"])) header ("Location: salir");
$da = registros("select idhogares_intervenciones as id, fecha, deno, supervisores, texto, usuario from hogares_intervenciones left join tablas on tablas.tipo='TINTH' and valo=hogares_intervenciones.tipo where hogar=".$id." and hogares_intervenciones.baja is null order by fecha desc");
?>
<div class="container">
<h2>Subir Archivos</h2>
<a href='hogaresarchivos?id=<?php echo $id;?>'>Archivos</a>
<h2>Historial de Acciones</h2>
  <a href='ninthogar?hogar=<?php echo $id;?>'>Nueva</a>
<div class="table-responsive pre-scrollable">
<table class="table">
<tr><td>Acc</td><td>Fecha</td><td>Tipo</td><td>Supervisores</td><td>Descripci&oacute;n</td><td>Usuario</td></tr>
<?php
while ( $dt = mysqli_fetch_assoc($da)){
echo colorfila()."<td>";
if($dt["usuario"]==$_SESSION["glusua"]) echo "<a href='hogares_intborrar?id=".$dt["id"]."'><img src='imagenes/eliminar.png' height='25' width='25' ></a>";
echo "</a></td><td>".ffec($dt["fecha"])."</td><td>".$dt["deno"]."</td><td>".$dt["supervisores"]."</td><td>".$dt["texto"]."</td><td>".$dt["usuario"]."</td></tr>";
};
?>

</table>
</div>
<h2>Visitas</h2>
<div class="table-responsive pre-scrollable">
<table class="table">
<tr><th>Opciones</th><th>Fecha</th><th>Supervisores</th><th>Hogar</th><th>Observaciones</th></tr>
<?php
$sql="select idsuper_visita as id, super_fecha, super_super, super_usuario, left(super_obse,60) as obse, nombre  from super_visita left join dispositivos on super_hogar=dispositivos.id where super_hogar=".$id;
$sql=$sql." order by super_fecha desc";
$conn=registros($sql);
$conta=1;
while ($vi = mysqli_fetch_assoc($conn)) {
 $conta=$conta+1;
 if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};
 echo "<td>*<a href='informevisita?id=".$vi['id']."'>Informe</a> ";
 if($vi['super_usuario']==$_SESSION['glusua']) echo "<a href='Supervisita?id=".$vi['id']."&baja=1'>Eliminar</a>";
 echo "</td>";
 echo "<td>".ffec($vi['super_fecha'])."</td><td>".$vi['super_super']."</td><td>".$vi['nombre']."</td><td>".$vi['obse']."</td>";
echo "</tr>";
};
?>
</table>
</div>
</div>


