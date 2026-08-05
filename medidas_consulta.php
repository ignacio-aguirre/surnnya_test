<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Env&iacuteo de medidas por mail";
if (!isset($_SESSION['gldispo'])) header ("Location: index.php");
include("encabezado.php");
$esta="A";
$hogar="";


if(isset($_SESSION['glhogar'])) {$hgrs="<option value='".$_SESSION['glhogar']."'>".$_SESSION['gldhogar']."</option>";} else $hgrs=$_SESSION['Opc_Hoga'];
?>
</div>
<div class="container">
<button class="btn-warning" onclick=navega("medidas_enviar")>Enviar Ahora</button><br><br>
<form class="form-inline" method="get" enctype="multipart/form-data">
<div class="form-group has-warning">
 <label class="label-form">Estado</label>
 <select class="form-control" name="iesta" id="i_esta"><option value=''>---Todos</option><option value='E'>Enviadas</option><option value='P'>No enviadas</option><option value='S'>Env.Suspendido</option></select>  
</div>
<input class="btn-primary" name="submit" type="submit" value="Consultar" />
<script type="text/javascript">enfoca("i_esta");seleccionar('i_esta','A');</script> 
</form>
<div class="table-responsive">
<table class="table" align="center">
<tr class="bg-primary">
<th>Id</th><th>Fecha</th><th>Apellidos y Nombres</th><th>Hogar</th><th>Email</th><th>Fecha Envio</th><th>Suspendido</th><th>Intentos</th>

<?php
if (isset($_GET["iesta"]))
{
$esta=$_GET["iesta"];
$sql="select idsujetos_medidas,fecha,apellidos,nombres, nombre,sujetos_medidas.email,envio,suspendido,intentos from sujetos_medidas  ";
	$sql=$sql." left join dispositivos on hogar=dispositivos.id ";
	$sql=$sql." left join sujetos on sujetos_medidas.legajo=sujetos.legajo where fecha>20220131";
        if($esta=='E') 	$sql=$sql." and envio is not null";
        if($esta=='P') 	$sql=$sql." and envio is null and suspendido=0";
        if($esta=='S') 	$sql=$sql." and suspendido=1";
	$sql=$sql." order by  ".si($esta=='E','envio','fecha')." desc,archivo";
  
	$conn = registros($sql);
	while ($da = mysqli_fetch_assoc($conn)) {
        echo colorfila();
         echo "<td>".$da["idsujetos_medidas"]."</td>";
         echo "<td>".ffec($da["fecha"])."</td>";
         echo "<td>".$da["apellidos"].", ".$da["nombres"]."</td>";
         echo "<td>".$da["nombre"]."</td>";
         echo "<td>".$da["email"]."</td>";
         echo "<td>".ffec($da["envio"])."</td>";	
         echo "<td>".$da["suspendido"]."</td>";
         echo "<td>".$da["intentos"]."</td>";
         echo "</tr>";};	
echo "<script>seleccionar('i_esta','".$_GET["iesta"]."');</script>";
      
};
echo "</table>";
 ?>
</div>
</div>
</body>
</html>