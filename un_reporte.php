<?php
include("Funciones.php");
session_start();
$id=nget("id");
$r=un_registro("select * from reportes where id=".$id);
$_SESSION["prestacion"]=si($id=="0","Nuevo Reporte","Editar Reporte Id=".$id);
include("encabezado.php");
?>
</div>
<div class="container">
<form class="form-inline" method="GET" action="un_reporte_do" onsubmit="return valida()">
 <div class="form-group has-warning">
	<label class="label-form" for="nombre_reporte">Nombre en Reporte</label>
	<input class="form-control" id="nombre_reporte" name="nombre_reporte" size="100" maxlength="300" value="<?php echo $r['nombre_reporte']?>" autofocus>
 </div>
 <br><br>
 <div class="form-group has-warning">
	<label class="label-form" for="nombre_menu">Nombre en Men&uacute;</label>
	<input class="form-control" id="nombre_menu" name="nombre_menu" size="100" maxlength="200" value="<?php echo $r['nombre_menu']?>">
 </div>
 <br><br>
 <div class="form-group has-warning">
	<label class="label-form" for="url_principal">URL Principal</label>
	<input class="form-control" id="url_principal" name="url_principal" size="30" maxlength="50"  value="<?php echo $r['url_principal']?>">
 </div>
 &nbsp;&nbsp;&nbsp;
 <div class="form-group has-warning">
	<label class="label-form" for="excel">Contiene salida a Excel</label>
	<select class="form-control" id="excel" name="excel">
        <option value="0">No</option>
        <option value="1">S&iacute;</option>
	</select>
	<script>seleccionar("excel","<?php echo $r['excel']?>")</script>
 </div>
 <br><br>
 <div class="form-group has-warning">
	<label class="label-form" for="definicion_operativa">Definici&oacute;n Operativa</label>
	<textarea class="form-control" cols="80" rows="10" id="definicion_operativa" name="definicion_operativa"><?php echo $r["definicion_operativa"]?></textarea>
 </div> 
 <input hidden name="id" value="<?php echo $id?>">
 <br><br>
 <button class="btn-primary" type="submit">Modificar</button>
</form>
<hr>
<h3>Men&uacute;es en los que este reporte est&aacute; incluido</h3>
<div class="table-responsive">
<table class="table table-condensed">
<tr class="bg-primary"><th>Men&uacute;</th><th>Opci&oacute;n Men&uacute; Superior</th><th>Orden en Men&uacute; Izquierdo</th><th>Quitar</th></tr>
<?php
 $men=registros("select menues.nombre, menues_superiores.titulo, menues_contenido.orden,idmenues_contenido from menues_contenido 
 left join menues on idmenues=menues_contenido.menu
 left join menues_superiores on menues_superiores.menu=menues_contenido.menu and menues_superiores.orden=menues_contenido.posicion
 where url=".tsql($r["url_principal"])." order by menues.nombre, menues_contenido.posicion");
 while($m=mysqli_fetch_assoc($men)){
   echo "<tr><td>".$m["nombre"]."</td><td>".$m["titulo"]."</td><td>".$m["orden"]."</td><td><button class='btn-small btn-danger' onclick='quitar(".$m["idmenues_contenido"].")'>Quitar</button></td></tr>";
 };
?>
</table>
</div>
<button class="btn-success" onclick="agregar('<?php echo $id?>')">Agregar en Otro Men&uacute;</button>
</div>
<script>
function agregar(id){
navega("reporte_menu?id="+id);
}
function quitar(id){
navega("reporte_menu_quitar?id="+id);
}


function valida(){
if(document.getElementById("nombre_reporte").value=="") return false;
if(document.getElementById("nombre_menu").value=="") return false;
if(document.getElementById("url_principal").value=="") return false;
return true;
}
</script>
</body>
</html>
