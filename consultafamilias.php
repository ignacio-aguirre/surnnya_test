<?php 
include("Funciones.php");
session_start();
include("encabezado.php");
registre();
$hoga= "";
if(isset($_GET['hogar'])) $hoga=$_GET['hogar'];
$estado1="1";
if(isset($_GET['estado1'])) $estado1=$_GET['estado1'];

?>

<script>
function nueva_familia(){
if(document.getElementById("hogar").value!=""){
url="af_familias_nueva?hogar="+document.getElementById("hogar").value;
navega(url);};

};

</script>
</div>
<div class="container">

<form class="form-inline" method="get">
<div class="form-group has-warning">
<label class="label-form">Dispositivo</label>
<select class="form-control" id='hogar' name='hogar' required><?php echo $_SESSION['Opc_Hoga_AF'];?>"</select>
</div>
<div class="form-group has-warning">
<label class="label-form">Estado 1</label>
<select class="form-control" id='estado1' name='estado1'>
<option value="1">Admitidas</option>
<option value="2">En evaluaci&oacute;n</option>
<option value="3">Con evaluaci&oacute;n Negativa</option>
<option value="4">Desisti&oacute;</option>
</select>
</div>
<input class="btn btn-primary" name="submit" type="submit" value="Consultar" />
</form>
<button class="btn-warning" type='button' onclick='nueva_familia()'>Nueva Familia</button>

<hr>

<h4>Resultado de la Consulta</h4>
<div class="table-responsive">
<table class="table-striped table-condensed">
<tr>
<tr class="bg-primary"><th>Id</th><th>Apellidos</th><th>Estado 2</th><th>En Acogimiento</th><th>Fecha Alta</th><th>Fecha Baja</th><th>Opciones</th></tr>

<?php

if (isset($_GET["hogar"])){

$conn = registros("select * from af_familias where estado1=".$_GET["estado1"]." and hogar=".$_GET["hogar"].si($_GET["hogar"]==170," order by case when registro_unico>0 then registro_unico else 9000 end, idaf_familias"," order by denominacion"));



while ($da = mysqli_fetch_assoc($conn)) {
   echo "<tr><td align='center'>".$da['idaf_familias']."</td>";
   echo "<td>".$da['denominacion']."</td>";

   echo "<td align='center'>".estado2($da["tipo_prestacion"])."</td>";
   $en_acog=un_campo("select count(*) from hogares_admision where admi_alta is not null and admi_baja is null and admi_hogar=".$_GET["hogar"]." and admi_fami=".$da["idaf_familias"]);
   echo "<td align='center'>".si($en_acog>"0","SI","NO")."</td>";
   echo "<td>".ffec($da["fecha_disposicion"])."</td>";
   echo "<td>".ffec($da["fecha_baja"])."</td><td>Consultar <img src='imagenes/reporte.png' height='25' width='25' onclick='consultar(".$da["idaf_familias"].")'>
    Editar <img src='imagenes/mas.png' height='25' width='25' onclick='editar(".$da["idaf_familias"].")'><br> ";
   
    echo "Cambiar Estado <img src='imagenes/Play.jpg' height='20' width='20' onclick='cambiaestado(".$da["idaf_familias"].")'></img></td>";
   
   echo "</tr>"; 
};

};
?>
</table>
</div>

<script type="text/javascript">
seleccionar("hogar","<?php echo $hoga;?>");
seleccionar("estado1","<?php echo $estado1;?>");
enfoca("hogar");
function cambiaestado(id){
 navega("af_cambiaestado?id="+id);
}
function consultar(id){
 navega("af_familias?id="+id);
}
function editar(id){
 navega("af_familias_editar?id="+id);
}


</script>

</div>

</body>

</html>

