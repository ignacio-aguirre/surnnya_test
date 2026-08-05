<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Replicar en miembros del grupo";
include("encabezado.php");
$id=$_GET["archivo"];
$lega=$_GET["legajo"];
$fecha=fsql($_GET["fecha"]);
$dias=nulea($_GET["dias"]);
$ninn=nulea($_GET["noinno"]);
$jumo=un_campo("select juzgado_modalidad from sujetos_juridicos where legajo=".$lega);
$junu=un_campo("select juzgado_numero from sujetos_juridicos where legajo=".$lega);
$juex=un_campo("select juzgado_expediente from sujetos_juridicos where legajo=".$lega);
$juca=un_campo("select juzgado_caratula from sujetos_juridicos where legajo=".$lega);

$dezo=un_campo("select defensoria_zonal from sujetos where legajo=".$lega);
if($ninn=="null") $ninn="0";
?>
<script>
function medida(lega){
    url="ej?tipo=MEDIDA_LEGA&arch="+"<?php echo $id;?>"+"&lega="+lega+"&fecha="+"<?php echo $fecha;?>"+"&dias="+"<?php echo $dias;?>"+"&noinno="+"<?php echo $ninn;?>"+"&jumo="+"<?php echo $jumo;?>"+"&junu="+"<?php echo $junu;?>"+"&juex="+"<?php echo $juex;?>"+"&juca="+"<?php echo $juca;?>"+"&dezo="+"<?php echo $dezo;?>";
    pet = new XMLHttpRequest();
    pet.open('GET', url, false);
    pet.send(null);
    var resp = pet.responseText;
    document.getElementById(lega).disabled=true;
    return true;
}
</script>
</div>
<div class="container">
  <div class="table-responsive">
   <table class="table">
    <tr class="bg-primary"><th>Apellidos</th><th>Nombres</th><th>Copiar Medida</th></tr>
<?php
$grup=un_campo("select grupo from grupos_legajos where grupo_legajo=".$lega);
if($grup!=""){
  $reg=registros("select * from grupos_legajos left join sujetos on grupo_legajo=legajo where grupo=".$grup);
  $c=0;
  while($r=mysqli_fetch_assoc($reg)){
    $c=$c+1;
    if($r["grupo_legajo"]!=$lega) echo colorfila()."<td>".$r["Apellidos"]."</td><td>".$r["Nombres"]."</td><td><input id='".$r["grupo_legajo"]."' type='checkbox' onclick=medida(".$r["grupo_legajo"].")></td></tr>";
  };
} else {Redirect("suje_cons_juridicos?legajo=".$lega);};

?>
</table>
</div>
<button type="button" onclick=navega("<?php echo 'suje_cons_juridicos?legajo='.$lega?>")>Volver</button>
</div>
</body>
</html>