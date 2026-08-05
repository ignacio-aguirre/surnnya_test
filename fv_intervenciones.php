<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])){ header ("Location: salir");};
if(isset($_GET["efector"])) $efector=$_GET["efector"];
$desde="";
$hasta="";
if(isset($_GET["desde"])){$desde=$_GET["desde"];};
if(isset($_GET["hasta"])){$hasta=$_GET["hasta"];};
$frase="";
if(isset($_GET["frase"])){$frase=$_GET["frase"];};

?>
<div class="container">
<form class="form-inline" onsubmit="return valida()">
 <div class='form-group has-warning'>
  <label class='label-form' for='desde'>Desde</label>
  <input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" autofocus value="<?php echo $desde?>">
 </div>&nbsp;&nbsp;
 <div class='form-group has-warning'>
  <label class='label-form' for='hasta'>Hasta</label>
  <input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)" value="<?php echo $hasta?>">
 </div>
 <br><br> 
 <div class="form-group has-warning">
<label class="label-form">Par&aacute;metro de B&uacute;squeda (todo o parte de los Apellidos / n&uacute;mero de legajo) </label>
<input class="form-control has-warning" name="frase" id="frase" size="30" maxlength="50" value="<?php echo $frase?>">
</div>
<br><br>
<input name="submit" type="submit" value="Consultar" />
&nbsp;&nbsp;<input class="btn-sm btn-success" name="excel" type="submit" value="Excel" />

</form>

<script type="text/javascript">
function editar(id){
  navega("fv_intervencion_editar?id="+id);	
}
function valida(){
valida_fecha("desde");
valida_fecha("hasta");
if(document.getElementById("desde").value==""){status("completar fecha desde");return false;};
if(document.getElementById("hasta").value==""){status("completar fecha hasta");return false;};
if(fsql(document.getElementById("hasta").value)<fsql(document.getElementById("desde").value)){status("fecha desde debe ser menor o igual que hasta");return false;};
status("");
return true;
}
</script> 

<div class='table-responsive'>

<table class='table table-striped table-bordered'>

<tr>

<th>Centro Zonal</th><th>Familia</th><th>Legajo</th><th>Fecha Ingreso</th><th>Estado</th><th>Opciones</th></tr>
<?php
if (isset($_GET["excel"])){Redirect("fv_intervenciones_excel?desde=".$_GET["desde"]."&hasta=".$_GET["hasta"]);};
if (isset($_GET["submit"]))

{

  $sql="select idfv_familias,fv_familias.descripcion, fv_familias.legajomanual,fv_participaciones.id,fv_participaciones.fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,sectores.denominacion,
   estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion) as estado 
   from fv_participaciones left join fv_familias on fv_participaciones.familia=idfv_familias left join sectores on fv_participaciones.efector=sectores.id where true  ";
   if(intval($frase)!=0) {$sql=$sql." and legajomanual=".$frase;}
  else{if($frase!=""){$sql=$sql." and descripcion like '%".$frase."%'";};};
   $sql=$sql."  and estado_sol(".fget("desde").",".fget("hasta").",fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion)<>'NUL'";
 $sql=$sql." order by descripcion";
  
   $conn = registros($sql);
   $conta=0;
   $perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);
   while ($da = mysqli_fetch_assoc($conn)) {
   	$conta=$conta+1;
      echo "<tr><td>".$da["denominacion"]."</td><td>".$da["descripcion"]."</td><td>".$da["legajomanual"]."</td><td>".ffec($da["fecha_ingreso"]).
           "</td><td>".$da["estado"]."</td>";
      if($perf_original!="41"){
	echo "<td><button class='btn btn-primary btn-sm' onclick='editar(".$da["id"].")'>Editar</button></td>";};
      echo "</tr>";	
    };
    echo "<tr style='font-size:.70em'><td>".$conta." registros</td><td></td><td></td><td></td><td></td></tr>";   
};



?>

</table>

</div>

<?php if(isset($conta)){ echo 'Total ';echo $conta;echo ' registros ';};
function efectorespropios(){
  $s="<option value='0'>Todos</option>";
  $reg=registros("select id, denominacion from sectores where programa=9 order by denominacion");
  while($r=mysqli_fetch_assoc($reg)){
    $s=$s."<option value=".$r["id"].">".$r["denominacion"]."</option>";
  };
  return $s;
}
?>
</body>
</html>