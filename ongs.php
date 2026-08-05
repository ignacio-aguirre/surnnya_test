<?php
include("Funciones.php");
session_start();
include("encabezado.php");
$frase="";
if(isset($_GET["frase"])){$frase=$_GET["frase"];};
$departamento="0";
if(isset($_GET["departamento"])){$departamento=$_GET["departamento"];};

?>
</div>
<div class="container">
<form class="form-inline" method="get">
<div class="form-group has-warning">
<label class="label-form">Par&aacute;metro de B&uacute;squeda (todo o parte de la Raz&oacute;n Social / n&uacute;mero de legajo) </label>
<input class="form-control has-warning" name="frase" id="frase" size="30" maxlength="50" autofocus value="<?php echo $frase?>">
</div>
<br><br>
<div class="form-group has-warning">
<label class="label-form">Departamento(s)</label>
<select class="form-control has-warning" name="departamento" id="departamento">
<option value="0">Ambos</option>
<option value="1">Monitoreo</option>
<option value="2">Fiscalizaci&oacute;n</option>
</select>
</div>
<input class="btn-warning btn-sm" type="submit" name="buscar" value="Buscar">
<input class="btn-success btn-sm" type="submit" name="excel"value="Excel">
</form>
<button class="btn-primary btn-sm" onclick='navega("una_ong?id=0")'>Nueva ONG</button>&nbsp;&nbsp;
<hr>
<div class="table-responsive">
<table class="table table-condensed" >
<tr class="bg-primary" style="font-size:.8em">
<th>Raz&oacute;n Social</th><th>Legajo</th><th>Referente Institucional</th><th>Tel&eacute;fonos</th><th>Email</th><th>Estado</th><th>Opciones</th></tr>

<?php
if(isset($_GET["excel"])){Redirect("ongs_lista?departamento=".$_GET["departamento"]);};
if($frase=="") {
 $sql="select * from hogares_ong left join tablas on tablas.tipo='EONG' and valo=estado ".si($departamento!="0"," where departamento=".$departamento,"")." order by nombre";}
else{
 if(intval($frase)!=0) {
   $sql="select * from hogares_ong left join tablas on tablas.tipo='EONG' and valo=estado where legajo=".intval($frase);}
 else{ $sql="select * from hogares_ong left join tablas on tablas.tipo='EONG' and valo=estado where nombre like '%".$frase."%'";};
 if($departamento!="0"){$sql=$sql." and departamento=".$departamento;};
 $sql=$sql." order by nombre";
};
$reg = registros($sql);
$conta=1; 

while ($r = mysqli_fetch_assoc($reg)) {
   $conta=$conta+1;
   echo "<tr style='font-size:.8em'><td>".$r['nombre']."</td>";
   echo "<td>".$r['legajo']."</td>";
   echo "<td>".$r['referente']."</td>";
   echo "<td>".$r['telefonos']."</td>";
   echo "<td>".$r['email']."</td>";
   echo "<td>".$r['deno']."</td>";
   echo "<td><button class='btn-small btn-warning' onclick='ver(".$r["id"].")'>Ver</button>&nbsp;
<button class='btn-small btn-primary' onclick='editar(".$r["id"].")'>Edi</button>
<button class='btn-small btn-info' onclick='archivos(".$r["id"].")'>Doc</button>
<button class='btn-small btn-success' onclick='dispositivos(".$r["id"].")'>Dis</button>
</td></tr>";
	
   };

?>
</table>
</div>
</div>
<script>
seleccionar("departamento","<?php echo $departamento?>");
function editar(id){
navega("una_ong?id="+id);
}
function ver(id){
naveganuevo("ongs_ver?id="+id);
}
function archivos(id){
navega("ongs_archivos?id="+id);
}
function dispositivos(id){
navega("ongs_dispositivos?id="+id);
}
</script>
</body>
</html>
