<?php
include("Funciones.php");
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
include("encabezado.php");
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];

if (isset($_GET["desde"]))
{
$fini=$_GET["desde"];
$ffin=$_GET["hasta"];
}
?>
</div>
<div class="container">
<form class="form-inline" method="get" action="" onsubmit="return false" enctype="multipart/form-data">
<div class="form-group has-warning">
<label class="label-form" for="desde">Desde</label>
<input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" value="<?php echo $fini;?>">
</div>
<div class="form-group has-warning">
<label class="label-form" for="hasta">Hasta</label>
<input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)" value="<?php echo $ffin;?>">
</div>
</form>
<button class="btn-primary" onclick="consultar()">Consultar</button>

<script type="text/javascript">
enfoca("desde");
function consultar(){
 valida_fecha("desde");
 valida_fecha("hasta");
 desde=document.getElementById("desde").value;
 hasta=document.getElementById("hasta").value;

 if(fsql(desde)>fsql(hasta)) return false;
 navega("altasbajas_log?desde="+desde+"&hasta="+hasta);
}
</script>
<div class="table-responsive pre-scrollable">
<table class="table">
<tr class="bg-primary">
<th>Usuario</th><th>Fecha Acc.</th><th>Acci&oacute;n</th><th>NNYA</th><th>Hogar</th><th>Operacion</th><th>Fecha Op.</th>
</tr>
<?php 
if (isset($_GET["desde"]))
{
$reg=registros("select altasybajas_log.usuario, fecha_accion, accion, concat(apellidos,', ',nombres) as apyn, nombre,
 case when operacion='A' then 'ALTA' else 'BAJA' end as doper, fecha_operacion from altasybajas_log
 left join sujetos on altasybajas_log.legajo=sujetos.legajo
 left join dispositivos on dispositivos.id=hogar
 where fecha_accion between ".fsql($fini)." and ".fsql($ffin)." order by fecha_accion desc");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["usuario"]."</td><td>".ffec($r["fecha_accion"])."</td><td>".$r["accion"]."</td><td>".$r["apyn"]
  ."</td><td>".$r["nombre"]."</td><td>".$r["doper"]."</td><td>".ffec($r["fecha_operacion"])."</td></tr>";
 };
}?>
</table>
</div>
</div>
</body>
