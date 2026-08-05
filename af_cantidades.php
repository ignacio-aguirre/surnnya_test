<?php
include("Funciones.php");
session_start();
include("encabezado.php");
registre();
$fecha=$_SESSION["DiaHoy"];
if(isset($_GET["fecha"])) {$fecha=$_GET["fecha"];};
?>
</div>
<div class="container">
<form class="form-inline" method='GET'>
 <div class="form-group has-warning">
 <label class="label-form">Fecha</label>
 <input class="form-control" size='10' maxlength='10' id='fecha' name='fecha' onblur='valida_fecha(this.id)' value='<?php echo $fecha;?>'> <input class='btn-primary' type='submit' name='accion' value='Consultar'>
</div>
&nbsp;<input class='btn-success' type='submit' name='accion' value='Excel'>
</form>
<hr>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Pertenencia</th><th>Dispositivo</th><th>Cantidad</th><th> 0 a 5 </th><th> 6 a 12 </th><th> 13 o + </th></tr>
<?php 
if(isset($_GET["fecha"])){
if($_GET["accion"]=="Excel"){Redirect("af_cantidades_excel?fecha=".$_GET["fecha"]);};
$fech=fsql($_GET["fecha"]);
$sql="select case when ong>0 then 'CONVENIADOS' else 'PROPIOS' end as perte,  nombre, count(*) as cantidad,
  sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")<6 then 1 else 0 end) as r5,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.") between 6 and 12 then 1 else 0 end) as r12,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")>12 then 1 else 0 end) as r13
    from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo
    left join dispositivos on admi_hogar=dispositivos.id
    where tipo_dispositivo=1 and admi_alta <=".$fech." and (admi_baja is null or admi_baja>".$fech.") group by perte, nombre, plazas   order by perte, nombre, plazas";

$reg=registros($sql);

while($r=mysqli_fetch_assoc($reg)){

echo colorfila()."<td>".$r["perte"]."</td><td>".$r["nombre"]."</td><td style='text-align:center;'>".$r["cantidad"].
"</td><td style='text-align:center;'>".$r["r5"]."</td><td style='text-align:center;'>".$r["r12"]."</td><td style='text-align:center;'>".$r["r13"]."</td></tr>";

};

echo colorfila()."</tr>";

$sql="select case when ong>0 then 'CONVENIADOS' else 'PROPIOS' end as deno , count(*) as cantidad,
  sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")<6 then 1 else 0 end) as r5,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.") between 6 and 12 then 1 else 0 end) as r12,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")>12 then 1 else 0 end) as r13
   from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo
    left join dispositivos on admi_hogar=dispositivos.id
  where  tipo_dispositivo=1 and  admi_alta is not null and admi_alta<=".$fech." and (admi_baja is null or admi_baja>".$fech.") 
  group by deno
  order by deno";
  
$reg=registros($sql);

$total=0;

$t5=0;

$t12=0;

$t13=0;


while($r=mysqli_fetch_assoc($reg)){

echo colorfila()."<td>Total </td><td>".$r["deno"]."</td><td style='text-align:center;'>".$r["cantidad"].

"</td><td style='text-align:center;'>".$r["r5"]."</td><td style='text-align:center;'>".$r["r12"]."</td><td style='text-align:center;'>".$r["r13"]."</td></tr>";

$total=$total+$r["cantidad"];

$t5=$t5+$r["r5"];

$t12=$t12+$r["r12"];

$t13=$t13+$r["r13"];

};

echo colorfila()."<td>TOTAL</td><td></td><td style='text-align:center;'>".$total."</td><td style='text-align:center;'>".$t5."</td><td style='text-align:center;'>".$t12."</td><td style='text-align:center;'>".$t13."</td></tr>";
};
?>
</table>
</div>
</div>

<script>
enfoca("fecha");

</script>

</body>

</html>



