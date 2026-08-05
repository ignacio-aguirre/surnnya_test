<?php
session_start();
include("Funciones.php");
if(isset($_GET["excel"])){Redirect("usuarios_hogares_excel");};
$hogar=nget("hogar");
$_SESSION["prestacion"]="Usuarios del Dispositivo ".un_campo("select nombre from dispositivos where dispositivos.id=".$hogar);
include("encabezado.php");
?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Apellidos y Nombres</th><th>Trimestrales</th><th>Profesi&oacute;n</th><th>Funci&oacute;n</th><th>Firma</th><th>Perfil Mv</th><th>Opciones<th></tr>
<?php
 $reg=registros("select usuarios_hogares.*, usuarios_hogares_roles.funcion as func from usuarios_hogares 
 left join usuarios_hogares_roles on usuarios_hogares.id=usuario 
 where usuarios_hogares.baja is null and (usuarios_hogares.hogar=".$hogar." or usuarios_hogares_roles.hogar=".$hogar.") order by apellidos, nombres");
 while($r=mysqli_fetch_assoc($reg)){
   echo "<tr><td>".$r["apellidos"]." , ".$r["nombres"]."</td><td>".si($r["es_trimestrales"]=="1","S&iacute;","No")."</td><td>".$r["profesion"]."</td><td>".$r["funcion"].$r["func"]."</td><td>".
 si($r["firma"]=="1","S&iacute;","No")."</td><td>".$r["perfil_moviles"]."</td><td><button onclick=navega('usuarios_hogares_editar?id=".$r["id"]."') class='btn-success'>Editar</button>
&nbsp;&nbsp<button onclick='eliminar(".$r["id"].")' class='btn-danger'>Eliminar</button></td></tr>";
 };	
?>
</table>
</div>
<hr>
<button class="btn-primary" onclick="nuevo()">Nuevo Usuario</button>
</div>
<script>
function nuevo(){
navega("usuarios_hogares_nuevo?&hogar=<?php echo $hogar?>");
}
function eliminar(id){
if(confirm("Confirmas la eliminacion?")){
 navega('usuarios_hogares_eliminar?id='+id);
}
}
</script>
</body>
</html>