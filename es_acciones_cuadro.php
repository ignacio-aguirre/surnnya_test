<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Acciones Gabinete Salud";
include("encabezado-test.php");
$desde="";
$hasta="";
if(isset($_GET["desde"])){
$desde=$_GET["desde"];
$hasta=$_GET["hasta"];

};
?>
</div>
<div class="container">
<form class="form-inline">
<div class="form-group has-warning">
 <label class="label-form">Desde</label>
 <input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" value="<?php echo $desde?>" autofocus required>
</div>
<div class="form-group has-warning">
 <label class="label-form">Hasta</label>
 <input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)"  value="<?php echo $hasta?>" required>
</div>
&nbsp;&nbsp;&nbsp;
<button class="btn-primary">Consultar</button>
</form>
<?php if(isset($_GET["desde"])){
$desd=fget("desde");
$hast=fget("hasta");
?>
<div class="table-responsive">
<table class="table table-condensed">
<tr class="bg-primary"><th>Profesi&oacute;n</th>
<?php
$reg=registros("select valo,deno from tablas where tipo='ESTIA' order by valo");
while($r=mysqli_fetch_assoc($reg)){
 echo "<th>".$r["deno"]."</th>";
}
?>
<th>Total</th></tr>
<?php
$reg=registros("select prof.deno, sum(case when es_acciones.tipo=1 then 1 else 0 end) as v1,sum(case when es_acciones.tipo=2 then 1 else 0 end) as v2,
sum(case when es_acciones.tipo=3 then 1 else 0 end) as v3,sum(case when es_acciones.tipo=4 then 1 else 0 end) as v4,
sum(case when es_acciones.tipo=5 then 1 else 0 end) as v5,sum(case when es_acciones.tipo=6 then 1 else 0 end) as v6,
sum(case when es_acciones.tipo=7 then 1 else 0 end) as v7, sum(case when es_acciones.tipo=8 then 1 else 0 end) as v8, count(*) as tot from es_acciones
left join tablas prof on prof.tipo='ESESP' and prof.valo=especialidad 
where estado=2 and fecha between ".$desd." and ".$hast." group by deno
 union all
select 'TOTAL' as deno, sum(case when es_acciones.tipo=1 then 1 else 0 end) as v1,sum(case when es_acciones.tipo=2 then 1 else 0 end) as v2,
sum(case when es_acciones.tipo=3 then 1 else 0 end) as v3,sum(case when es_acciones.tipo=4 then 1 else 0 end) as v4,
sum(case when es_acciones.tipo=5 then 1 else 0 end) as v5, sum(case when es_acciones.tipo=6 then 1 else 0 end) as v6, 
sum(case when es_acciones.tipo=7 then 1 else 0 end) as v7,sum(case when es_acciones.tipo=8 then 1 else 0 end) as v8,  count(*) as tot from es_acciones
where estado=2 and fecha between ".$desd." and ".$hast." order by deno");
while($r=mysqli_fetch_assoc($reg)){
 echo "<tr><td>".$r["deno"]."</td><td>".si($r["v1"]==0,"",$r["v1"])."</td><td>".si($r["v2"]==0,"",$r["v2"]).
 "</td><td>".si($r["v3"]==0,"",$r["v3"])."</td><td>".si($r["v4"]==0,"",$r["v4"])."</td><td>".si($r["v5"]==0,"",$r["v5"]).
 "</td><td>".si($r["v6"]==0,"",$r["v6"])."</td><td>".si($r["v7"]==0,"",$r["v7"])."</td><td>".si($r["v8"]==0,"",$r["v8"])."</td><td>".$r["tot"]."</td></tr>";
}
?>
</table>
</div>
<?php };?>
</div>
</body>
</html>