<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Grupos de Hermanos / Grupos Maternos Editar Datos";
include("encabezado.php");
if($_SESSION['gl_editar_sujeto']==0) Redirect($_SESSION["menu"]);
$r=un_registro("select * from grupos where idgrupos=".$_GET["id"]);
?>
<div class="container">
<form class="form-inline" onsubmit="return false">
<div class="form-group has-warning">
<label class="control-label" for="apellidos">Apellidos</label>
<input class="form-control" id="apellidos" value="<?php echo $r['apellidos']?>" onblur="valida_0(this.id)" size="60" maxlength="200">
</div>
</form>
<form class="form-inline" onsubmit="return false">
<div class="form-group has-warning">
<label class="control-label" for="categoria">Categor&iacute;a</label>
<select class="form-control" id="categoria"><option value=1>Hermanos</option><option value=2>Materno Infantil</option></select>
</div>
</form>
<button class="btn-primary" onclick="actualizar()">Actualizar y pasar a Miembros</button>&nbsp;&nbsp;<button class="btn-warning" onclick="obtener()">Obtener Datos</button>
</div>
<script>
enfoca("apellidos");
function actualizar(){
valida_0("apellidos");
apellidos=document.getElementById("apellidos").value;
if(apellidos=="") return false;
categoria=document.getElementById("categoria").value;
navega("grupo_editar_do?id=<?php echo $r['idgrupos']?>"+"&apellidos="+apellidos+"&categoria="+categoria);
}

function obtener(){
respuesta=ejec("grupo_obtener","","&id=<?php echo $r['idgrupos']?>");
haymadre=respuesta.substring(0,1);
if(haymadre=="0") {seleccionar("categoria",1);}
else {seleccionar("categoria",2);};
apellidos=respuesta.substring(1,200);
document.getElementById("apellidos").value=apellidos;
return true;
}

</script>