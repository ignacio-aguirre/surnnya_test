<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
?>
</div>
<div class="container">
<form method="get"  enctype="multipart/form-data">
<fieldset>
<table>
<tr><td>Primer d&iacute;a del mes</td><td><input name="fecha" id="fecha" size="8" maxlength="10" onblur="valida_fecha(this.id)"></td></tr>
</table>
<input name="submit" type="submit" value="Consultar" />
</fieldset>
<script type="text/javascript">enfoca("fecha");</script> 
</form>
<table align="center">
<?php
$conta=0;
if (isset($_GET["fecha"]))
{
 $fecha=$_GET["fecha"];
 $flim=ffec(un_campo("select DATE_ADD(".fsql($fecha).",INTERVAL 1 MONTH) from dual"));
 $flim=ffec(un_campo("select DATE_ADD(".fsql($flim).",INTERVAL -1 DAY) from dual"));
echo "<script type='text/javascript'>document.getElementById('fecha').value='".$fecha."'</script>";
	$sql="select *, case when tipo_dispositivo=1 then concat(case when dispositivos.id=170 then 'AF: ' else concat('F.',right(trim(nombre),7)) end ,':',af_familias.denominacion) else nombre end as hogar, 
        Apellidos, Nombres from hogares_admision ";
	$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";
	$sql=$sql." left join dispositivos on admi_hogar=dispositivos.id ";
	$sql=$sql." left join af_familias on admi_fami=idaf_familias ";
	$sql=$sql." where admi_alta<=".fsql($flim)." and (admi_baja is null or admi_baja>=".fsql($fecha).")";
	$sql=$sql." order by  hogar, Apellidos, Nombres";
        $conn = registros($sql);
        echo "<div class='table-responsive'><table class='table'>
        <tr class='bg-primary'><th>Hogar</th><th>Apellido y Nombre</th><th>RIB</th></tr>";  
	while ($da = mysqli_fetch_assoc($conn)) {
         $conta=$conta+1;
         echo "<td>".$da["hogar"]."</td>";         
         $apel=$da["Apellidos"];
	 $nomb= $da["Nombres"];
         echo "<td>".reemplaza($apel)." , ".$nomb."</td>";	
         echo "<td>".rib2($da)."</td>";	
         echo "</tr>";};



};	

echo "</table>";

echo $conta, " NNYA</div>";

?>

</div>

</body>

</html>