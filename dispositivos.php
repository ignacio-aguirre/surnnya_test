<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
$frase="";
if(isset($_GET["frase"])){$frase=$_GET["frase"];};
$tipo="0";
if(isset($_GET["tipo"])){$tipo=$_GET["tipo"];};
$editar=un_campo("select editar_dispositivos from perfiles where id=".$_SESSION["glidperfil"]);
?>
</div>
<div class="container">
<form class="form-inline" method="get">
<div class="form-group has-warning">
<label class="label-form">Par&aacute;metro de B&uacute;squeda (todo o parte del Nombre / n&uacute;mero de legajo) </label>
<input class="form-control has-warning" name="frase" id="frase" size="30" maxlength="50" autofocus value="<?php echo $frase?>">
</div>
<br><br>
<div class="form-group has-warning">
<label class="label-form">Tipo Dispositivo</label>
<select class="form-control has-warning" name="tipo" id="tipo">
<option value="0">Todos</option>
<?php echo opc_tabla("DITIP")?>
</select>
</div>

<input class="btn-warning btn-sm" name="buscar" type="submit" value="Buscar">
<input class="btn-success btn-sm" name="excel" type="submit" value="Excel Dispositivos">

</form>
<?php if($editar=="1"){?>
<button class="btn-primary btn-sm" onclick='navega("un_dispositivo?id=0")'>Nuevo Dispositivo</button>&nbsp;&nbsp;
<?php }?>
<hr>
<div class="table-responsive">
<table class="table table-condensed" >
<tr class="bg-primary" style="font-size:.8em">
<th>Nombre Dispositivo</th><th>Legajo</th><th>Referente</th><th>Tel&eacute;fonos</th><th>Email</th><th>Tipo Dispositivo</th><th>Estado</th><th>N&oacute;mina CDNNYA</th><th>Opciones</th></tr>

<?php
if(isset($_GET["excel"])){Redirect("dispositivos_lista?tipo=".$_GET["tipo"]);};
if($frase=="") {
 $sql="select dispositivos.*,hogares_ong.legajo,deno from dispositivos left join tablas on tablas.tipo='DITIP' and valo=tipo_dispositivo left join hogares_ong on hogares_ong.id=ong  where baja_sistema is null ";}
else{
 if(intval($frase)!=0) {
   $sql="select dispositivos.*,hogares_ong.legajo,deno from dispositivos left join tablas on tablas.tipo='DITIP' and valo=tipo_dispositivo left join hogares_ong on hogares_ong.id=ong where legajo=".intval($frase)." and baja_sistema is null ";}
 else{ $sql="select dispositivos.*,hogares_ong.legajo,deno from dispositivos  left join tablas on tablas.tipo='DITIP' and valo=tipo_dispositivo left join hogares_ong on hogares_ong.id=ong where dispositivos.nombre like '%".$frase."%' and baja_sistema is null ";}
};
if($tipo!="0"){$sql=$sql." and tipo_dispositivo=".$tipo;};
$sql=$sql." order by nombre";
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
   echo "<td>".si(ffec($r["baja"])=="","Alta","Baja")."</td>";
   echo "<td>".si($r["nomina_hogares"]=="1","SI","NO")."</td>";
   echo "<td><button class='btn-small btn-warning' onclick='ver(".$r["id"].")'>Ver</button>&nbsp;";
   if($editar=="1"){
echo "<button class='btn-small btn-primary' onclick='editar(".$r["id"].")'>Editar</button>";
} else {
  echo "<button class='btn-small btn-primary' onclick='u_mon(".$r["id"].")'>F.Ult.Monitoreo</button>";
}
echo "<button class='btn-small btn-info' onclick='archivos(".$r["id"].")'>Documentaci&oacute;n</button>
</td></tr>";
	
   };

?>
</table>
</div>
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
function u_mon(id){
  navega("dispositivo_monitoreo?id="+id);
}
seleccionar("tipo","<?php echo $tipo?>");
</script>
</body>
</html>
