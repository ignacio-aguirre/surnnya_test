<?php
include("Funciones.php");
session_start();
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
$cate="";
$opci=str_replace("Completar","Todas",$_SESSION["Opc_Hoga_Cate"]);
if (isset($_GET["idesde"]))
{
$fini=$_GET["idesde"];
$ffin=$_GET["ihasta"];
$cate=$_GET["icate"];}
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
<label>Categor&iacute;as</label><select name="icate" id="i_cate"><?php echo $opci;?></select>
<input name="submit" type="submit" value="Consultar" />
</fieldset>
<script type="text/javascript">
document.getElementById("i_cate").value="<?php echo $cate?>";
enfoca("i_desde")</script> 
</form>

<div class="table-responsive">
<table class="table table-bordered table-striped">
<tr>
<th>Acciones</th><th>Legajo</th><th>Apellido y Nombre</th><th>Edad (Fecha Asig.)</th><th>Hogar</th><th>Fecha Asig.</th>
<tr>
<?php
if (isset($_GET["mensaje"])) echo $_GET["mensaje"];
if (isset($_GET["idesde"]))
{
$sql="select *,   edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,admi_fderiv) as edad,sujetos.legajo as lega, case when tipo_dispositivo=1 then concat('AF: ',denominacion) else nombre end as hogar from hogares_admision inner join dispositivos on dispositivos.id=admi_hogar left join af_familias on admi_fami=idaf_familias";
$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";
$sql=$sql." where ".si($cate=="","","admi_cate=".$cate." and ")." admi_fderiv between ".fsql($fini)." and ".fsql($ffin)." order by admi_fderiv desc";
$conn = registros($sql);
$conta=1;
while ($da = mysqli_fetch_assoc($conn)) {
  $conta=$conta+1;
  echo "<tr><td>";
  if($_SESSION['gl_admi']==1 && gettype($da['admi_alta'])=="NULL") echo "<a href='admiborraderiv?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/eliminar.png'></a>";
  echo "</td>";
  echo "<td>".$da['lega']."</td>";
  echo "<td>".$da['Apellidos']." , ".$da['Nombres']."</td>";
  echo "<td>".$da["edad"]."</td>";
  echo "<td>".$da["hogar"]."</td>";
  echo "<td>".ffec($da["admi_fderiv"])."</td>";  
  echo "</tr>";}
};
?>

</table>
</div>
<?php if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};?>

</body>

</html>