<?php
include("Funciones.php");
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
include("encabezado-test.php");
?>
<div class="container">
<form class="form-inline" method="get"  enctype="multipart/form-data">
<div class="form-group has-warning">
<label class="label-form">Desde</label>
<input class="form-control" type="text" name="fini" size="10" maxlength="10" id="fini" onblur="valida_fecha('fini')" value="<?php echo $fini;?>"> 
</div>
<div class="form-group has-warning">
<label class="label-form">Hasta</label>
<input class="form-control" type="text" name="ffin" size="10" maxlength="10" id="ffin" onblur="valida_fecha('ffin')" value="<?php echo $ffin;?>"> 
</div>&nbsp;&nbsp;
<input name="submit" type="submit" value="Consultar" />

<script type="text/javascript">enfoca("fini");</script> 

</form>
<h4>Pedidos por tipos de dispositivos diferenciados</h4>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tr>
<th>Categor&iacute;a</th><th>Cantidad</th><th>Pendientes</th><th>Suspendidos</th><th>Asignados</th><th>Altas</th><th>Bajas</th>



<?php

if (isset($_GET["fini"]))

{

 $fini=$_GET["fini"];

 $ffin=$_GET["ffin"];



 $sql="select deno, count(*) as tota, sum(case when admi_fderiv is null and admi_susp is null  then 1 else 0 end) as pend,
 sum(case when admi_fderiv is null and admi_susp is not null then 1 else 0 end) as susp, 
 sum(case when admi_fderiv is not null then 1 else 0 end) as deriv,
 sum(case when admi_alta is not null then 1 else 0 end) as altas,
 sum(case when admi_baja is not null then 1 else 0 end) as bajas
 from hogares_admision left join tablas on tablas.tipo='ADCAT' and admi_cate=valo where admi_fped between ".fsql($fini)." and ".fsql($ffin)." group by deno union all 

 select 'TOTAL' as deno, count(*) as tota, sum(case when admi_fderiv is null and admi_susp is null then 1 else 0 end) as pend,

 sum(case when admi_fderiv is null and admi_susp is not null then 1 else 0 end) as susp, 

 sum(case when admi_fderiv is not null then 1 else 0 end) as deriv,

 sum(case when admi_alta is not null then 1 else 0 end) as altas,

 sum(case when admi_baja is not null then 1 else 0 end) as bajas

 from hogares_admision left join tablas on tablas.tipo='ADCAT' and admi_cate=valo where admi_fped between ".fsql($fini)." and ".fsql($ffin)." order by deno";



 $conn = registros($sql);

  while ($da = mysqli_fetch_assoc($conn)) {

    

    echo "<tr><td>".$da["deno"]."</td><td>".$da["tota"]."</td><td>".$da["pend"]."</td><td>".$da["susp"]."</td><td>".$da["deriv"]."</td><td>".$da["altas"]."</td><td>".$da["bajas"]."</td></tr>";

 };

};



?>

</table>
</div>
<h4>Pedidos por Sector Solicitante</h4>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tr>
<th>Sector Solicitante</th><th>Cantidad</th><th>Pendientes</th><th>Suspendidos</th><th>Asignados</th><th>Altas</th><th>Bajas</th>
<?php
if (isset($_GET["fini"]))

{

$sql="select info, count(*) as tota, sum(case when admi_fderiv is null and admi_susp is null  then 1 else 0 end) as pend,
 sum(case when admi_fderiv is null and admi_susp is not null then 1 else 0 end) as susp, 
 sum(case when admi_fderiv is not null then 1 else 0 end) as deriv,
 sum(case when admi_alta is not null then 1 else 0 end) as altas,
 sum(case when admi_baja is not null then 1 else 0 end) as bajas
 from hogares_admision left join tablas on tablas.tipo='CM' and admi_deriv_sector=valo where admi_fped between ".fsql($fini)." and ".fsql($ffin)." group by info union all 
 select 'TOTAL' as info, count(*) as tota, sum(case when admi_fderiv is null and admi_susp is null then 1 else 0 end) as pend,
 sum(case when admi_fderiv is null and admi_susp is not null then 1 else 0 end) as susp, 
 sum(case when admi_fderiv is not null then 1 else 0 end) as deriv,
 sum(case when admi_alta is not null then 1 else 0 end) as altas,
 sum(case when admi_baja is not null then 1 else 0 end) as bajas
 from hogares_admision left join tablas on tablas.tipo='CM' and admi_deriv_sector=valo where admi_fped between ".fsql($fini)." and ".fsql($ffin)." order by info";
 $conn = registros($sql);
  while ($da = mysqli_fetch_assoc($conn)) {
    echo "<tr><td>".$da["info"]."</td><td>".$da["tota"]."</td><td>".$da["pend"]."</td><td>".$da["susp"]."</td><td>".$da["deriv"]."</td><td>".$da["altas"]."</td><td>".$da["bajas"]."</td></tr>";
 };

};



?>



</table>
</div>
</div>

</body>

</html>