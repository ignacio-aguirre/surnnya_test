<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])){ header ("Location: salir");};
$desde="";
$hasta="";
if(isset($_GET["desde"])){$desde=$_GET["desde"];};
if(isset($_GET["hasta"])){$hasta=$_GET["hasta"];};
$frase="";
if(isset($_GET["frase"])){$frase=$_GET["frase"];};
?>
<div class="container">
<form class="form-inline" method="get" onsubmit="return valida()">
<div class="form-group has-warning">
 <label class="label-form">Ingreso Desde</label>
 <input class="form-control" name="desde" id="desde" size="10" maxlength="10" onblur="valida_fecha(this.id)" value="<?php echo $desde?>" autofocus>
</div>&nbsp;&nbsp;
<div class="form-group has-warning">
 <label class="label-form">Hasta</label>
 <input class="form-control" name="hasta" id="hasta" size="10" maxlength="10" onblur="valida_fecha(this.id)" value="<?php echo $hasta?>">
</div>
<br><br> 
 <div class="form-group has-warning">
<label class="label-form">Par&aacute;metro de B&uacute;squeda (todo o parte de los Apellidos / n&uacute;mero de legajo) </label>
<input class="form-control has-warning" name="frase" id="frase" size="30" maxlength="50" value="<?php echo $frase?>">
</div>
<br><br>

<input class="btn-warning btn-sm" type="submit" name="consultar" value="Consultar">
<input class="btn-success btn-sm" type="submit" name="excel" value="Excel">
</form>
<?php
$perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);
if($perf_original!="41"){?>
<button class="btn-sm btn-info" onclick="navega('fv_solicitudes_nueva')">Nueva</button>
<?php }?>
<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr class="bg-primary" style="font-size:.8em">
<th>Fecha Ingreso</th><th>Derivante</th><th>Expediente</th><th>Legajo</th><th>Grupo Familiar</th><th>Estado</th><th>Fecha</th><th>Opciones</th></tr>
<?php
 if(isset($_GET["excel"])){Redirect("fv_solicitudes_excel?desde=".$_GET["desde"]."&hasta=".$_GET["hasta"]);};
 if(isset($_GET["consultar"])){
  $sql="select fv_participaciones.*,fv_familias.descripcion, fv_familias.legajomanual,tablas.info  from fv_participaciones left join fv_familias on fv_participaciones.familia=idfv_familias 
 left join tablas on tablas.tipo='CM' and tablas.valo=derivante where fecha_ingreso between ".fget("desde")." and ".fget("hasta");
 if(intval($_GET["frase"])!=0) {$sql=$sql." and legajomanual=".$_GET["frase"];}
  else{if($_GET["frase"]!=""){$sql=$sql." and descripcion like '%".$_GET["frase"]."%'";};};
 $sql=$sql." order by fecha_ingreso";
   $reg = registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
   	$conta=$conta+1;
      echo "<tr style='font-size:.8em;'><td>".ffec($r["fecha_ingreso"])."</td><td>".si($r["info"]=="",$r["derivante_especificar"],$r["info"])."</td><td>".$r["expediente"]."</td><td>".$r["legajomanual"]."</td><td>".$r["descripcion"]."</td><td>".estado($r)."</td><td>";
     if($r["fecha_asignacion"]=="" && $r["fecha_rechazo"]=="" && $r["fecha_articulacion"]=="" && $perf_original!="41") {
     echo "<button class='btn-sm btn-primary' onclick='editar(".$r["id"].")'>Editar</button>&nbsp;";
     };
     if(substr(ffec($r["fecha_ingreso"]),-7)==substr($_SESSION["DiaHoy"],-7) && $perf_original!="41"){echo "<button class='btn-sm btn-danger' onclick='eliminar(".$r["id"].")'>Eliminar</button>&nbsp;";};
     echo "</td></tr>";	
    };
};
?>

</table>

</div>
<script>
function valida(){
valida_fecha("desde");
valida_fecha("hasta");
if(document.getElementById("desde").value==""){status("completar fecha desde");return false;};
if(document.getElementById("hasta").value==""){status("completar fecha hasta");return false;};
if(fsql(document.getElementById("hasta").value)<fsql(document.getElementById("desde").value)){status("fecha desde debe ser menor o igual que hasta");return false;};
status("");
return true;
}
function editar(id){
 navega("una_solicitud_fv?id="+id);
}
function eliminar(id){
 if(confirm("Confirmas la eliminacion de esta solicitud?")){navega("fv_solicitudes_eliminar?id="+id);};
}
</script>
<?php if(isset($conta)){ echo 'Total ';echo $conta;echo ' registros ';};
function estado($r){
  $e="Evaluaci&oacute;n Condiciones";
  $f="";
  if($r["fecha_condiciones"]!=""){
   $e="P/ASIGNAR";
   $f=ffec($r["fecha_condiciones"]);
  };
  if($r["fecha_asignacion"]!=""){
   $e="ASIGNADA";
   $f=ffec($r["fecha_asignacion"]);
  };
  if($r["fecha_rechazo"]!=""){
   $e="RECHAZADA";
   $f=ffec($r["fecha_rechazo"]);
  };
  if($r["fecha_cancelacion"]!=""){
   $e="CANCELADA";
   $f=ffec($r["fecha_cancelacion"]);
  };

  if($r["fecha_articulacion"]!=""){
   $e="ARTICULADA";
   $f=ffec($r["fecha_articulacion"]);
  };

  return $e."</td><td>".$f;
}
?>
</body>
</html>