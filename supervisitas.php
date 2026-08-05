<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
$hoga="";
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
if(isset($_GET['enviar'])) {$hoga=$_GET['hogar'];$fini=$_GET['fini'];$ffin=$_GET['ffin'];};
$perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);
if($_SESSION["gldispo"]=="144"){
  $opci_h="";
  $hogs=registros("select dispositivos.id, nombre from dispositivos where tipo_dispositivo=11 and baja is null and area_gubernamental=1");
}
else {
$opci_h="<option></option>";

if($perf_original=="5" || $perf_original=="21"|| $perf_original=="63") {
  $hogs=registros("select dispositivos.id, nombre from dispositivos where tipo_dispositivo=2 and baja is null and area_gubernamental=1");
}
else if($perf_original=="62" || $perf_original=="43") {
  $hogs=registros("select dispositivos.id, nombre from dispositivos where tipo_dispositivo=1 and baja is null and area_gubernamental=2");
};
if($_SESSION["extendido"]=="1"){
  $hogs=registros("select dispositivos.id, nombre from dispositivos where tipo_dispositivo in(2,11) and baja is null and area_gubernamental=1");
};
};
while($sh=mysqli_fetch_assoc($hogs)){
  $opci_h=$opci_h."<option value='".$sh["id"]."'>".$sh["nombre"]."</option>";
};
?>
<div class="container">
<form class="form-inline" method='get' onsubmit='return valida_campos()'>
<label>Desde/Hasta</label><input class="form-control" size="10" maxlength="10" name="fini" id="i_desde" onblur="valida_fecha('i_desde')" value="<?php echo $fini;?>">
<input class="form-control" size="10" maxlength="10" name="ffin" id="i_hasta" onblur="valida_fecha('i_hasta')" value="<?php echo $ffin;?>">
<label>Hogar</label><select class="form-control" name='hogar' id='hogar'><?php echo $opci_h;?></select>
<input class="btn-small btn-primary" type='Submit' name='enviar' value='Consultar'>
<?php if($perf_original!="41"){?>
<button class="btn-small btn-warning" type='Button' onclick='creavisita()'>Nueva Visita</button>
<?php }?>
</form>



<script type="text/javascript">

function valida_campos() {
valida_fecha("fecha");
valida_0("super");
valida_0("obse");
var hoga=document.getElementById("hogar").value;
var fini=document.getElementById("fini").value;
var ffin=document.getElementById("ffin").value;
if(fini==""||ffin=="") {alert("Complete los Campos");return false;};
return true;

}



function creavisita() {
var hoga=document.getElementById("hogar").value;
if(hoga!="") navega("supervisita?id=0&hogar="+hoga);
return true;

}
enfoca("i_desde");
seleccionar("hogar","<?php echo $hoga;?>");
</script>

<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Opciones</th><th>Fecha</th><th>Supervisores</th><th>Hogar</th><th>Acta</th></tr>
<?php

$sql="select idsuper_visita as id, super_fecha, super_super, super_usuario, nombre  
from super_visita left join dispositivos on super_hogar=dispositivos.id 
where super_fecha between ".fsql($fini)." and ".fsql($ffin);
if($hoga!=""){$sql=$sql." and super_hogar=".$hoga;}
else if($_SESSION["gldispo"]=="144"){
	$sql=$sql." and tipo_dispositivo=11 ";

}
else if($perf_original=="5" || $perf_original=="21"){$sql=$sql." and tipo_dispositivo=2";}

else if($perf_original=="62" || $perf_original=="43") {
	$sql=$sql." and tipo_dispositivo=1 ";
};

$sql=$sql." order by super_fecha desc";

$conn=registros($sql);

$conta=0;

while ($vi = mysqli_fetch_assoc($conn)) {

 $conta=$conta+1;

 echo colorfila()."<td>";

 if($_SESSION['glcons']!="1" && $perf_original!="41") echo "<a href='supervisita?id=".$vi['id']."'>Editar</a> ";

 echo "&nbsp;<a href='informevisita?id=".$vi['id']."'>Informe</a> ";

 echo "</td>";

 $ruta=un_campo("select as_path from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where tipo='V' and identificador=".$vi['id']);

 echo "<td>".ffec($vi['super_fecha'])."</td><td>".$vi['super_super']."</td><td>".$vi['nombre']."</td><td>".
si($ruta!="","<a href='".$ruta."'>Descargar</a>","")."</td>";

echo "</tr>";

};

echo "</table></div>Total:".$conta;

?>

</div>

</body>

</html>