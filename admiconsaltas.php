<?php 
include("Funciones.php");
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
include("encabezado-test.php");
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
$hogar="";
$excluir="";
$sinnota="";
$diop="";
$circ="";
$perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);

if(isset($_SESSION['glhogar'])) {$hgrs="<option value='".$_SESSION['glhogar']."'>".$_SESSION['gldhogar']."</option>";} else $hgrs=str_replace("Completar","Todos",$_SESSION['Opc_Hoga']);
if (isset($_GET["desde"]))
{
$excluir=$_GET["excluir"];
$fini=$_GET["desde"];
$ffin=$_GET["hasta"];
$hogar=$_GET["hogar"];
$sinnota=$_GET["sinnota"];
$diop=$_GET["direccion_operativa"];
$circ=$_GET["circuito"];

};
?>

</div>
<div class="container">
<form class="form" onsubmit="return false" enctype="multipart/form-data">
 <div class="form-group row has-warning">
  <div class="col-md-3">
   <label class="label-form" for="desde">Desde</label>
   <input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" value="<?php echo $fini;?>" autofocus>
  </div>
  <div class="col-md-3">
   <label class="label-form" for="hasta">Hasta</label>
   <input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)" value="<?php echo $ffin;?>">
  </div>
 </div>
 <div class="form-group row has-warning">
  <div class="col-md-4">
  <label class="label-form" for="direccion_operativa">Direcci&oacute;n Operativa</label>
   <select class="form-control" id="direccion_operativa" name='direccion_operativa'>
    <option value="0">Todas</option>
    <?php echo opc_tabla("DIOP");?>
   </select>
 </div>
<script>seleccionar("direccion_operativa","<?php echo $diop?>");</script>
 <div class="col-md-2">
  <label class="label-form" for="circuito">Circuito</label><select class="form-control" id="circuito" name='circuito'>
  <option value="0">Red de Hogares</option>
  <option value="1">Preingreso</option>
  <option value="2">Resid.DGSAP</option>
  </select>
 </div>
<script>seleccionar("circuito","<?php echo $circ?>");</script>
 </div>
 <div class="form-group row has-warning">
  <div class="col-md-9">
   <label class="label-form" for="hogar">Hogar:</label>
   <select class="form-control" name="hogar" id="hogar" autofocus><?php echo $hgrs;?></select>
  </div>
 </div>
 <div class="form-group row has-warning">
  <div class="col-md-3">
   <label class="label-form" for="excluir"> Excluir Cambios de Hogar </label>
   <input class="form-control" type="checkbox" id="excluir" <?php echo si($excluir=="1"," checked","");?>>
  </div>
 <div class="col-md-3">
  <label class="label-form" for="sinnota"> Filtrar adem&aacute;s por falta de nota </label>
  <input class="form-control" type="checkbox" id="sinnota" <?php echo si($sinnota=="1"," checked","");?>>
 </div>
 <div class="col-md-3">
   <button class="btn-primary form-control" onclick="consultar()">Pantalla</button>
 </div>
 <div class="col-md-3">
   <button class="btn-success form-control" onclick="excel()">Excel</button>
 
 </div>
</div>
</form>
<script type="text/javascript">

function consultar(){
 valida_fecha("desde");
 desde=document.getElementById("desde").value;
 valida_fecha("hasta");
 hasta=document.getElementById("hasta").value;
 if(fsql(desde)>fsql(hasta)){status("fecha desde debe ser menor o igual que hasta");return false;};
 hogar=document.getElementById("hogar").value;
 diop=document.getElementById("direccion_operativa").value;
 circ=document.getElementById("circuito").value;
 excluir="";
 sinnota="";
 if(document.getElementById("excluir").checked) excluir="1";
 if(document.getElementById("sinnota").checked) sinnota="1";
 status("");
 navega("admiconsaltas?desde="+desde+"&hasta="+hasta+"&hogar="+hogar+"&excluir="+excluir+"&sinnota="+sinnota+"&direccion_operativa="+
diop+"&circuito="+circ);
}
function excel(){
 valida_fecha("desde");
 desde=document.getElementById("desde").value;
 valida_fecha("hasta");
 hasta=document.getElementById("hasta").value;
 if(fsql(desde)>fsql(hasta)){status("fecha desde debe ser menor o igual que hasta");return false;};
 status("");
 diop=document.getElementById("direccion_operativa").value;
 circ=document.getElementById("circuito").value;
 hogar=document.getElementById("hogar").value;
 navega("admiconsaltas_excel?desde="+desde+"&hasta="+hasta+"&hogar="+hogar+"&direccion_operativa="+diop+"&circuito="+circ);
}

function archivos(id){
navega("archivos_vacante?id="+id);
};
</script> 

<div class="table-responsive pre-scrollable">
<table class="table">
<tr style='font-size:.75em;' class="bg-info">
<th>Acciones</th><th>Doc/Legajo</th><th>Apellido y Nombre</th><th>Edad Alta</th><th>Hogar</th><th>Fecha Alta</th><th>Motivo de Ingreso</th><th>Nt.Alta</th><th>Cert.Aloj.</th><th>Desv</th><tr>

<?php

if (isset($_GET["desde"]))

{

$sql="select *,sujetos.legajo as lega, nombre as dhogar, ming.deno as moti, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,fecha_operacion) as edc,
 nal.idarchivos_subidos as alta_id, nde.idarchivos_subidos as deri_id, td.deno as tdoc     
from altasybajas left join hogares_admision on vacante=idhogares_admision
 left join archivos_subidos nal on nota=nal.idarchivos_subidos 
 left join archivos_subidos nde on nota_derivacion=nde.idarchivos_subidos 
 left join dispositivos on dispositivos.id=altasybajas.hogar ";
$sql=$sql." left join sujetos on altasybajas.legajo=sujetos.legajo left join tablas hogares_de on hogares_de.tipo='ADDER' and hogares_de.valo=admi_deriv ";
$sql=$sql." left join tablas td on td.tipo='TD' and td.valo=tipodni ";
$sql=$sql." left join tablas ming on ming.tipo='HOMOI' and ming.valo=admi_moti ";
$sql=$sql." where operacion='A' and fecha_operacion between ".fsql($fini)." and ".fsql($ffin);
if($hogar!="") $sql=$sql." and admi_hogar=".$hogar;
if($excluir!="") $sql=$sql. " and admi_moti not in (5,19)"; 
if($sinnota!="") $sql=$sql. " and not nota>0 "; 
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and direccion_operativa=".$diop;
$sql=$sql." order by fecha_operacion desc";
$conn = registros($sql);
$conta=1;
while ($da = mysqli_fetch_assoc($conn)) {
  $conta=$conta+1;
  $lega=$da['lega'];
  $documento=$da["tdoc"]." ".$da["SujetosDNI"];
  if(gettype($da["SujetosDNI"])=="NULL") $documento="Leg. ".$lega;
  echo "<tr style='font-size:.75em;'><td>";
  if($_SESSION['gl_admi']==1 &&gettype($da['admi_baja'])=="NULL" && $perf_original!="41")
  echo "<a href='admiborraalta?id=".$da["idaltasybajas"]."'><img height='15' width='15' src='imagenes/eliminar.png'></a>";
  echo "</td>";
  echo "<td><a href='suje_cons_duros?legajo=".$lega."'>".$documento."</a></td>";
  echo "<td>".$da['Apellidos']." , ".$da['Nombres']."</td>";
  echo "<td>".$da['edc']."</td>";
  echo "<td>".$da["dhogar"]."</td>";
  echo "<td>".ffec($da["fecha_operacion"])."</td>";
  echo "<td>".$da["moti"]."</td><td>";
  if($da["nota"]==0){
    if($perf_original!="41") {echo "<a href='subir_archivos?altabaja=".$da["idaltasybajas"]."&ret=admiconsaltas'>Subir</a>";};}
  else{
    echo "<a href='descarga_nuevo?id=".$da["alta_id"]."'>Descargar</a>";
  };
  echo "</td><td>";
  echo si($da["nota_derivacion"]==0,si($_SESSION['gl_admi']==1,"<a href='subir_archivos?altabaja=".$da["idaltasybajas"]."&tipo=201&ret=admiconsaltas'>Subir</a>",
   "")."&nbsp;<a href='alojamiento_cert?id=".$da["idaltasybajas"]."'>TXT</a>","<a href='descarga_nuevo?id=".$da["deri_id"]."'>Descargar</a>")."</td><td>";
  if($_SESSION['gl_admi']==1 &&($da["nota"]!=0||$da["nota_derivacion"]!=0)) echo "<img src='imagenes/eliminar.png' height='15' width='15' onclick='archivos(".$da["idaltasybajas"].")'>";

  echo "</td></tr>";}

};

?>

</table>

</div>

<?php if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};?>



</div>

</body>

</html>