<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
$desd=$_SESSION["DiaHoy"];
$hast=$_SESSION["DiaHoy"];
if (isset($_GET["desde"]))
{
$desd=$_GET["desde"];
$hast=$_GET["hasta"];
};
?>

<div class="container">

<form class="form-inline" method="get" enctype="multipart/form-data">
<div class="form-group has-warning">
<label class="label-form" for="desde">Desde</label>
<input class="form-control"name="desde" id="desde" size="8" maxlenght="10" onblur="valida_fecha(this.id)" value="<?php echo $desd;?>">
</div>
<div class="form-group has-warning">
<label class="label-form" for="hasta">Hasta</label>
<input class="form-control" name="hasta" id="hasta" size="8" maxlenght="10" onblur="valida_fecha(this.id)" value="<?php echo $hast;?>">
</div>
<input class="form-control" name="submit" type="submit" value="Emitir" />
</form>

<script type="text/javascript">enfoca("desde");</script> 


<strong>Ingresos al circuito categor&iacute;a beb&eacute;s</strong>

<table border="1" align="center">

<tr>

<th>A&ntilde;o/Mes</th><th>a Hogares</th><th>a Familias</th><th>Total</th>

<?php

if (isset($_GET["desde"]))

{

 $cate="5";

 $sql="select concat(year(admi_alta),'-',month(admi_alta)) as periodo, sum(case when tipo_dispositivo=1 then 0 else 1 end) as hogares, sum(case when tipo_dispositivo=1 then 1 else 0 end) as familias, count(*) as total

   from hogares_admision

    left join dispositivos on admi_hogar=dispositivos.id 

    where admi_cate=5 and admi_alta between ".fsql($desd)." and ".fsql($hast);

    $sql=$sql." group by periodo order by  periodo ";

  $hoga=0;

  $fami=0;

  $tota=0;

$reg = registros($sql);

    while ($r = mysqli_fetch_assoc($reg)) {

     echo "<tr><td>".$r["periodo"]."</td><td>".$r["hogares"]."</td><td>".$r["familias"]."</td><td>".$r["total"]."</td></tr>";

     $hoga=$hoga+$r["hogares"];

     $fami=$fami+$r["familias"];

     $tota=$tota+$r["total"];

     };

echo "<tr><td>TOTAL</td><td>".$hoga."</td><td>".$fami."</td><td>".$tota."</td></tr>";		

};



?>

</table>

</div>

</body>

</html>