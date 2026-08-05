<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="B&uacute;squeda de NNYA";
include("encabezado-test.php");
$pedidorecurso="0";
$pedidopae="0";
$inclusionpae="0";
$ffv="0";
$coba="0";
$cj="0";
$jt="0";
if (isset($_GET["pedidorecurso"])) {$pedidorecurso=$_GET["pedidorecurso"];};
if (isset($_GET["pedidopae"])) {$pedidopae=$_GET["pedidopae"];};
if (isset($_GET["inclusionpae"])) {$inclusionpae=$_GET["inclusionpae"];};
if (isset($_GET["cj"])) {$cj=$_GET["cj"];};
if (isset($_GET["ffv"])) {$ffv=$_GET["ffv"];};

$h18=false;
if(isset($_GET["h18"])){
   if($_GET["h18"]=="on"){$h18=true;};
};   
$alojados=false;
if(isset($_GET["alojados"])){
if($_GET["alojados"]=="on"){$alojados=true;};
};
$frase="";

if (isset($_GET["frase"])) $frase=trim($_GET["frase"]);

?>
<div class="container">
<h3>Encontr&aacute; el legajo de un NNYA a partir de un texto</h3>
<form class="form-inline" method="get" action="consultasujetos" onsubmit="return valida_datos()">

<div class="form-group has-warning">
<input class="form-control" type="text" size='60' maxlength='60' name="frase" id='frase' required autofocus value="<?php echo $frase;?>" placeholder="
Pod&eacute;s buscar por nombre, apellido, dni y RIB" />
</div><br>
<div class="form-group has-warning">
<label class="label-form" for="h18">Hasta 18 a&ntilde;os</label>
<input class="form-control" type="checkbox" name="h18">
</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="form-group has-warning">
<label class="label-form" for="alojados">Alojados en Dispositivos de Cuidado</label>
<input class="form-control" type="checkbox" name="alojados">
<input type="hidden" name="pedidorecurso" value="<?php echo $pedidorecurso;?>">
<input type="hidden" name="pedidopae" value="<?php echo $pedidopae;?>">
<input type="hidden" name="inclusionpae" value="<?php echo $inclusionpae;?>">
<input type="hidden" name="cj" value="<?php echo $cj;?>">
<input type="hidden" name="ffv" value="<?php echo $ffv;?>">
</div>
<br>
<input class="form-control btn-primary" type="submit" value="Buscar" />
</form>

<?php

if (isset($_GET["frase"])){
$conn = registros(buscador_pibes($frase,$h18,$alojados));

echo "<h4>Legajos encontrados (primeros 15)</h4>

<div class='table-responsive'>

<table class='table table-striped table-bordered table-condensed'>

<thead><tr class='bg-primary'><th>RIB</th> <th align='left'>Apellidos, Nombres</th><th align='left'>Otros Nombres</th><th>DNI</th><th>Edad</th><th>Alojad@ en Hogar</th><th>Domicilio</th></thead>

<tbody>";

$cant = mysqli_num_rows($conn);
$urlbase="suje_cons_duros";
if($pedidorecurso=="1") $urlbase="admision_pedidonuevo";
if($pedidopae=="1") $urlbase="pae_solicitud";
if($inclusionpae=="1") $urlbase="pae_inclusion";
if($cj=="1") $urlbase="alpre_ingreso";
if($ffv=="1") $urlbase="fv_nnya_alta";
if ($cant==1) {

 $da = mysqli_fetch_assoc($conn);

 
 
 $url="Location: ".$urlbase."?legajo=".$da['legajo'];

 header ($url);}         

elseif ($cant== 0) {alerte("No se ha encontrado coincidencia.");}

else {



while ($da = mysqli_fetch_assoc($conn)) {
   $url_aux=	"navega('".$urlbase."?legajo=".$da['legajo']."')";	
   echo cf($url_aux)."<td align='center'>".rib($da['rib_anio'],$da['rib_numero'],$da['rib_reparticion'])."</td>";
   echo "<td>".$da['apellidos'].", ".$da['nombres']."</td>";
   echo "<td>".$da['apodos']."</td>";
   echo "<td>".$da['SujetosDni']."</td>";
   echo "<td style='text-align:center;'>".$da['edad_c']."</td>";
   echo "<td style='text-align:center;'>".$da['hoga']."</td>";
   echo "<td>".str_replace("S/I","",$da['proc']." ".$da['Lugvivienda'])."</td>";
   echo "</tr>"; };

};

};

?>

</tbody>

</table>

</div>

<?php if(isset($_GET["frase"]) && $cant==0){
echo "<br><button class='btn-success' onclick='navega(".'"sujetonuevo"'.")'>Nuevo Legajo</button>";}?>
<script>

function valida_datos() {

var fras=document.getElementById("frase").value.length;

var apel=document.getElementById("ape").value.length;

var nomb=document.getElementById("nom").value.length;

var apod=document.getElementById("apo").value.length;

var dni=document.getElementById("dni").value.length;

if(fras<4&&apel<4&&nomb<4&&apod<4&&dni<4) {alert("Complete campo para buscar, alguno de ellos con más de tres letras");return false;};

return true;

}

</script>

</div>



</body>

</html>

