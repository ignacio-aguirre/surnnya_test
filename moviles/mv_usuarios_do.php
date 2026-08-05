<?php
session_start();
include("funciones.php");
$dispositivo=nget("dispositivo");
$_SESSION["prestacion"]="Usuarios del Dispositivo ".un_campo("select nombre from dispositivos where dispositivos.id=".$dispositivo);
include("encabezado.php");
?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table">
<tr class="bg-dark text-white"><th>Apellidos y Nombres</th><th>Usuario</th><th>Opciones<th></tr>
<?php
 $reg=registros("select * from movil_usuarios 
 where baja is null and dispositivo=".$dispositivo." order by apellidos, nombres");
 while($r=mysqli_fetch_assoc($reg)){
   echo "<tr><td>".$r["apellidos"]." , ".$r["nombres"]."</td><td>".$r["acronimo"]."</td><td><button onclick=navega('mv_usuarios_editar?id=".$r["id"]."') class='btn-sm btn-success'>Editar</button>
&nbsp;&nbsp<button onclick='eliminar(".$r["id"].")' class='btn-sm btn-danger'>Eliminar</button></td></tr>";
 };
?>
</table>
</div>
<br>
<button class="btn-primary" onclick="nuevo()">Nuevo Usuario</button>
</div>
<script>
function nuevo(){
navega("mv_usuarios_nuevo?&dispositivo=<?php echo $dispositivo?>");
}
function eliminar(id){
if(confirm("Confirmas la eliminacion?")){
 navega('mv_usuarios_eliminar?id='+id);
}
}

</script>
</body>
</html>