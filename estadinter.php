<?php
include("Funciones.php");
session_start();
registre();
$opci="";
if ($_SESSION["gl_todos_dispo"]==1) $opci="<option value='0'>--Todos</option>";
$opci=$opci.$_SESSION['Opc_dispo'];
$sql="select valo, concat(info,'-',deno) as denom from tablas where tipo='TINT' order by denom";
$conn = registros($sql);
$opci3="";
while ($da = mysqli_fetch_assoc($conn)) $opci3=$opci3."<option value='".$da['valo']."'>".$da['denom']."</option>";
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class="form-inline" method="POST">
<div class="form-group has-warning">
<label class="label-form">Fecha Desde</label>
<input class="form-control" name="ifdes" id="fdes" onblur="valida_fecha('fdes')" value="<?php if(isset($_POST['ifdes'])) echo $_POST['ifdes'];?>" size="10" autofocus>
</div>
<div class="form-group has-warning">
<label class="label-form">Fecha Hasta</label>
<input class="form-control" name="ifhas" id="fhas" onblur="valida_fecha('fhas')" value="<?php if(isset($_POST['ifhas'])) echo $_POST["ifhas"];?>" size="10">
</div>
<div class="form-group has-warning">
<label class="label-form">Dispositivo</label>
<select class="form-control" name='idispo' id='dispo'><?php echo $opci;?></select>
</div>
<br><br>
<button class="btn btn-primary" type="submit">Emitir</button>
</form>
<?PHP
if (isset($_POST['ifdes']))
{
if($_POST['idispo']=="0") {$dispo="true";} else $dispo="inter_dispo='".$_POST['idispo']."'";
$fdes=$_POST['ifdes'];
$fhas=$_POST['ifhas'];
$fdes=fsql($fdes); 
$fhas=fsql($fhas); 
$turno=" true ";
$sql="select 'Totales' as descr, COUNT(DISTINCT  Inter_legajo)  as camp1 from intervenciones where ".$dispo." and ".$turno." and inter_fecha between ".$fdes." and ".$fhas;
$sql=$sql." union select sexo as descr, count(*) as camp1 from sujetos where legajo in (select DISTINCT inter_legajo from intervenciones where ".$dispo." and ".$turno." and inter_fecha between ".$fdes." and ".$fhas.") group by sexo";
$conn = registros($sql);

echo "<div class='table-responsive'><table class='table'>";

echo "<tr class='bg-primary'><th>Nnya con Acciones</th><th>Cantidad</th></tr>";

while ($da = mysqli_fetch_assoc($conn))  {echo "<tr><td>".$da["descr"]."</td><td align='right'>".$da["camp1"]."</td></tr>";}

echo "</table></div>";


$sql="select edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,sujetosActedad,null) as descr, count(*) as camp1";

$sql=$sql." from sujetos where sujetos.legajo in (select distinct inter_legajo from intervenciones where ".$dispo." and ".$turno." and inter_fecha between ".$fdes." and ".$fhas.") group by descr";

$conn = registros($sql);

echo "<div class='table-responsive'><table class='table'>";

echo "<tr class='bg-primary'><th>Edad (hoy)</th><th>Cantidad</th></tr>";

while ($da = mysqli_fetch_assoc($conn))  {echo colorfila()."<td>";

if($da["descr"]!="") {echo $da["descr"];} else echo "S/D";

echo "</td><td align='right'>".$da["camp1"]."</td></tr>";}

echo "</table></div>";


echo "<div class='table-responsive'><table class='table'>";



$sql="select 'Totales' as descr, count(*) as camp1 from intervenciones where ".$dispo." and ".$turno." and inter_fecha between ".$fdes." and ".$fhas;

$sql=$sql." union select sexo as descr, count(*) as camp1 from intervenciones inner join sujetos on inter_legajo=legajo where ".$dispo." and ".$turno." and inter_fecha between ".$fdes." and ".$fhas." group by sexo";

$conn = registros($sql);

echo "<tr class='bg-primary'><th>Acciones Realizadas</th><th>Cantidad</th></tr>";

while ($da = mysqli_fetch_assoc($conn))  {echo colorfila()."<td>".$da["descr"]."</td><td align='right'>".$da["camp1"]."</td></tr>";}

echo "</table></div>";



$sql="select edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,null)as descr, count(*) as camp1";

$sql=$sql." from sujetos inner join intervenciones on inter_legajo=sujetos.legajo where  ".$dispo." and ".$turno." and inter_fecha between ".$fdes." and ".$fhas."  group by descr";

$conn = registros($sql);

echo "<div class='table-responsive'><table class='table'>";

echo "<tr class='bg-primary'><th>Edad (hoy)</th><th>Cantidad</th></tr>";

while ($da = mysqli_fetch_assoc($conn))  {echo colorfila()."<td>";

if($da["descr"]!="") {echo $da["descr"];} else echo "S/D";

echo "</td><td align='right'>".$da["camp1"]."</td></tr>";}

echo "</table></div>";

echo "<div class='table-responsive'><table class='table'>";

echo "<tr class='bg-primary'><th>Grupo</th><th>Tipo de Intervenci&oacute;n</th><th>Total</th></tr>";

$sql="select info as gru,deno as tip, count(*) as camp1 from intervenciones left join tablas on inter_tipo=valo and tablas.tipo='TINT' where ".$dispo." and ".$turno." and inter_fecha between ".$fdes." and ".$fhas. " group by gru,tip";

$conn = registros($sql);

while ($da = mysqli_fetch_assoc($conn))  {echo colorfila()."<td>".$da["gru"]."</td><td>".$da["tip"]."</td><td align='right'>".$da["camp1"]."</td></tr>";}

echo "</table></div>";


echo "<div class='table-responsive'><table class='table'>
<tr class='bg-primary'><th>Efector Salud</th><th>Cantidad</th></tr>";
 $sql="select descripcion, count(*) as cant from intervenciones left join salud_establecimientos on inter_hosp=idsalud_establecimientos where inter_fecha between ".$fdes." and ".$fhas." and ".$dispo." and ".$turno." and inter_hosp is not null group by descripcion order by descripcion ";
 $conn=registros($sql);
 while ($da = mysqli_fetch_assoc($conn))  {echo colorfila()."<td>".$da["descripcion"]."</td><td align='right'>".$da["cant"]."</td></tr>";};
 echo "</table>";
 echo "</div>";



echo "<div class='table-responsive'><table class='table'>";

$sql="select case when edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.") is null then '6. S/D' else case when edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.")<8 then '1. < 8 a.' else case when edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.")<13 then '2. 08 a 12 a.' else case when edadcalc(f_nacimiento,sujetosEdad,null,sujetosActEdad,".$fhas.")<18 then '3. 13 a 17 a.' else '4. > 18 o + a.' end end end end as  descr, count(*) as camp1";

$sql=$sql." from sujetos where sujetos.legajo in (select distinct inter_legajo from intervenciones where ".$dispo." and ".$turno." and inter_fecha between ".$fdes." and ".$fhas.") group by descr";

$conn = registros($sql);



echo "<tr class='bg-primary'><th>Rango Etario</th><th>Cantidad</th></tr>";

while ($da = mysqli_fetch_assoc($conn))  {echo colorfila()."<td>";

if($da["descr"]!="") {echo $da["descr"];} else echo "S/D";

echo "</td><td align='right'>".$da["camp1"]."</td></tr>";}

echo "</table></div>";



echo "<div class='table-responsive'><table class='table'>";
echo "<tr class='bg-primary'><th>Legajo</th><th>DNI</th><th>Apellido y Nombre</th><th>Edad (hoy)</th><th>Meses</th<th>Procedencia</th><th>Ranchada</th><th>Parada</th><th>Cantidad</th></tr>";
$sql="select sujetos.legajo,sujetosdni, apellidos, nombres, concat(vivienda.descripcion,'-',vivienda.grupo,case when vivienda.tipo='C' then ' Comuna:' else '' end,case when vivienda.tipo='C' then vivienda.comuna else '' end) as proc, concat(parada.descripcion,'-',parada.grupo,case when parada.tipo='C' then 'Comuna:' else '' end, case when parada.tipo='C' then parada.comuna else '' end) as para,  edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,sujetosActEdad,null) as edad, SujetosMeses, (select count(*) from intervenciones where inter_legajo=sujetos.legajo and inter_fecha between ".$fdes." and ".$fhas." and ".$dispo." and ".$turno.") as cantidad from sujetos 
left join localidades as vivienda on vivienda.idlocalidades=locvivienda 
left join localidades as parada on parada.idlocalidades=locparada 
where sujetos.legajo in (select distinct inter_legajo from intervenciones where inter_fecha between ".$fdes." and ".$fhas." and ".$dispo." and ".$turno.") order by apellidos, nombres";

$conn = registros($sql);

while ($da = mysqli_fetch_assoc($conn))  {echo colorfila();

echo "<td><a href='consultaunsujeto?vlegajo=".$da["legajo"]."'>".$da["legajo"]."</a></td>";

echo "<td>".$da["sujetosdni"]."</td>";

echo "<td>".$da["apellidos"]." , ".$da["nombres"]."</td><td>";

if($da["edad"]!="") {echo $da["edad"];} else echo "S/D";

echo "</td><td>".$da["SujetosMeses"]."</td><td>".$da["proc"]."</td><td>".$da["para"]."</td><td>".$da["cantidad"]."</td></tr>";}

echo "</table></div><p align='center'><a href='".$_SESSION['menu']."'>Men&uacute;</a></p></div>"; 



}

?>

</body>





</html>