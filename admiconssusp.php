<?php
include("Funciones.php");
session_start();
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
if (isset($_GET["idesde"]))
{
$fini=$_GET["idesde"];
$ffin=$_GET["ihasta"];}
include("encabezado-test.php");
?>

<div class="container">
<?php
if (isset($_GET["mensaje"])) echo $_GET["mensaje"];
?>
<form method="get" enctype="multipart/form-data">
<fieldset>
<label>Desde</label><input type="text" size="10" maxlength="10" name="idesde" id="i_desde" onblur="valida_fecha('i_desde')" value="<?php echo $fini;?>">
<label>Hasta</label><input type="text" size="10" maxlength="10" name="ihasta" id="i_hasta" onblur="valida_fecha('i_hasta')" value="<?php echo $ffin;?>">
<input name="submit" type="submit" value="Consultar" />
</fieldset>

<script type="text/javascript">enfoca("i_desde")</script> 
</form>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tr>
<th>Acciones</th><th>Apellido y Nombre</th><th>Hogar</th><th>Suspensi&oacute;n</th><th>Motivo</th><th>Observaciones</th>
<tr>
<?php
if (isset($_GET["mensaje"])) echo $_GET["mensaje"];
if (isset($_GET["idesde"]))
{
$sql="select *,sujetos.legajo as lega, case when tipo_dispositivo=1 then concat('AF: ',denominacion) else nombre end as hogar from hogares_admision left join dispositivos on dispositivos.id=admi_hogar left join af_familias on admi_fami=idaf_familias";
$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";
$sql=$sql." left join tablas on admi_motivo_suspension=valo and tipo='ADMSU'";
$sql=$sql." where admi_susp between ".fsql($fini)." and ".fsql($ffin)." order by admi_susp desc";
$conn = registros($sql);
$conta=1;
while ($da = mysqli_fetch_assoc($conn)) {
  $conta=$conta+1;
  echo "<tr><td>";
  echo "<a href='admiborrasusp?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/eliminar.png'></a>";
  echo "</td>";
  echo "<td>".$da['Apellidos']." , ".$da['Nombres']."</td>";

  echo "<td>".$da["hogar"]."</td>";

  echo "<td>".ffec($da["admi_susp"])."</td>";  
  echo "<td>".$da['deno']."</td>";

  echo "<td>".$da["admi_mots"]."</td>";

  echo "</tr>";}

};

?>

</table>
</div>
<?php if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};?>
</div>
</body>

</html>