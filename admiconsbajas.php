<?php
include("Funciones.php");
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
include("encabezado-test.php");
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
$hogar="";
if(isset($_SESSION['glhogar'])) {$hgrs="<option value='".$_SESSION['glhogar']."'>".$_SESSION['gldhogar']."</option>";} else $hgrs=str_replace("Completar","Todos",$_SESSION['Opc_Hoga']);
$excluir="";
$sinnota="";
$diop="";
$circ="";
$perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);

if (isset($_GET["desde"]))
{
$fini=$_GET["desde"];
$ffin=$_GET["hasta"];
$hogar=$_GET["hogar"];
$excluir=$_GET["excluir"];
$sinnota=$_GET["sinnota"];
$diop=$_GET["direccion_operativa"];
$circ=$_GET["circuito"];
}

?>
</div>
<div class="container">
<form class="form" method="get" action="" onsubmit="return false" enctype="multipart/form-data">
 <div class="form-group row has-warning">
  <div class="col-md-2">
   <label class="label-form" for="desde">Desde</label>
   <input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" value="<?php echo $fini;?>" autofocus>
  </div>
  <div class="col-md-2">
   <label class="label-form" for="hasta">Hasta</label>
   <input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)" value="<?php echo $ffin;?>">
  </div>
  <div class="col-md-2">
  <label class="label-form" for="direccion_operativa">Direcci&oacute;n Operativa</label>
   <select class="form-control" id="direccion_operativa" name='direccion_operativa'>
    <option value="0">Todas</option>
    <?php echo opc_tabla("DIOP");?>
   </select>
 </div>
<script>seleccionar("direccion_operativa","<?php echo $diop?>");</script>
 <div class="col-md-2">
  <label class="label-form" for="circuito">Circuito</label>
 <select class="form-control" id="circuito" name='circuito'>
  <option value="0">Red de Hogares</option>
  <option value="1">Preingreso</option>
  <option value="2">Resid.DGSAP</option>
  </select>
 </div>
<script>seleccionar("circuito","<?php echo $circ?>");</script>
 </div>
 <div class="form-group row has-warning">
  <div class="col-md-9">
   <label class="label-form" for="hogar">Hogar</label>
   <select class="form-control" name="hogar" id="hogar"><?php echo $hgrs;?></select>
  </div>
 </div>
<script>seleccionar("hogar","<?php echo $hogar?>");</script>

 <div class="form-group row has-warning">
  <div class="col-md-3">
	<label class="label-form" for="excluir"> Excluir Cambios de Hogar </label>
	<input class="form-control" type="checkbox" id="excluir" <?php echo si($excluir=="1"," checked","");?>>
  </div>
  <div class="col-md-3">
	<label class="label-form" for="sinnota"> Filtrar adem&aacute;s por falta de nota </label>
	<input class="form-control"type="checkbox" id="sinnota" <?php echo si($sinnota=="1"," checked","");?>>
  </div>
  <div class="col-md-2">
	<button class="btn-primary form-control" onclick="consultar()">Pantalla</button>
  </div>
  <div class="col-md-2">
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
 excluir="";
 sinnota="";
 diop=document.getElementById("direccion_operativa").value;
 circ=document.getElementById("circuito").value;
 if(document.getElementById("excluir").checked) excluir="1";
 if(document.getElementById("sinnota").checked) sinnota="1";
 
 status("");
 navega("admiconsbajas?desde="+desde+"&hasta="+hasta+"&hogar="+hogar+"&excluir="+excluir+"&sinnota="+sinnota+"&direccion_operativa="+diop+"&circuito="+circ);
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
 navega("admiconsbajas_excel?desde="+desde+"&hasta="+hasta+"&hogar="+hogar+"&direccion_operativa="+diop+"&circuito="+circ);
}


function archivos(id){
navega("archivos_vacante?id="+id);
};

</script> 
<div class="table-responsive pre-scrollable">
<table class="table">
<tr class="bg-info" style='font-size:.8em'><th>Acciones</th><th>Doc/Legajo</th><th>Apellido y Nombre</th><th>Fecha Nac.</th><th style='font-size:.7em;'>Edad Baja</th><th>Hogar</th><th>Fecha Baja</th><th>Motivo Egreso</th><th>Nota</th></tr>
<?php
if (isset($_GET["desde"])) {
$sql="select *,sujetos.legajo as lega, td.deno as tdoc, hogares_motegreso.deno as me, edadcalc(f_nacimiento,sujetosEdad,null,SujetosActEdad,fecha_operacion) as edc from 
altasybajas left join hogares_admision on vacante=idhogares_admision
left join dispositivos on dispositivos.id=hogar 
left join archivos_subidos on nota=idarchivos_subidos ";
$sql=$sql." left join sujetos on altasybajas.legajo=sujetos.legajo ";
$sql=$sql." left join tablas td on td.tipo='TD' and td.valo=tipodni ";
$sql=$sql." left join tablas hogares_motegreso on hogares_motegreso.valo=admi_mote and hogares_motegreso.tipo='HOMOE'";
$sql=$sql." where operacion='B'  and fecha_operacion between ".fsql($fini)." and ".fsql($ffin);
if($hogar!="") $sql=$sql." and hogar=".$hogar;
if($excluir!="") $sql=$sql. " and admi_mote<>4"; 
if($sinnota!="") $sql=$sql. " and not nota>0";
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and direccion_operativa=".$diop;
$sql=$sql." order by fecha_operacion desc";

$conn = registros($sql);
$conta=1;
while ($da = mysqli_fetch_assoc($conn)) {
  $conta=$conta+1;
  echo "<tr style='font-size:.8em'>";
  $lega=$da['lega'];
  $documento=$da["tdoc"]." ".$da["SujetosDNI"];
  if(gettype($da["SujetosDNI"])=="NULL") $documento="Leg. ".$lega;
  echo "<td>";
   if($_SESSION['gl_admi']==1) echo "<a href='admiborrabaja?id=".$da["idaltasybajas"]."'><img height='15' width='15' src='imagenes/eliminar.png'></a>";
  echo "</td>";
  echo "<td><a href='suje_cons_duros?legajo=".$lega."'>".$documento."</a></td>";
  echo "<td>".$da['Apellidos']." , ".$da['Nombres']."</td>";
  echo "<td>".ffec($da['f_nacimiento'])."</td>";
  echo "<td>".$da['edc']."</td>";
  echo "<td>".$da["nombre"]."</td>";
  echo "<td>".ffec($da["fecha_operacion"])."</td>";  
  echo "<td>".$da["me"]."</td><td>";
  if($da["nota"]==0){
   if($perf_original!="41") {echo "<a href='subir_archivos?altabaja=".$da["idaltasybajas"]."&ret=admiconsbajas'>Subir</a>";};}
  else{
   echo "<a href='descarga_nuevo?id=".$da["idarchivos_subidos"]."'>Descargar</a>&nbsp;&nbsp";
   if($perf_original!="41") {echo "<img src='imagenes/eliminar.png' height='15' width='15' onclick='archivos(".$da["idaltasybajas"].")'>";}
   };
  echo "</td></tr>";};

};

?>

</table>

</div>

<?php if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};?>

</div>

</body>

</html>