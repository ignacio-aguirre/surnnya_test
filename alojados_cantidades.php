<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
$fecha=$_SESSION["DiaHoy"];
if(isset($_GET["fecha"])) {
 $fecha=$_GET["fecha"];
 $circ=$_GET["circuito"];
 $diop=$_GET["direccion_operativa"];
};

?>
</div>
<div class="container">
<form class="form" method='GET'>
 <div class="form-group row has-warning">
  <div class="col-md-2">
   <label class="label-form">Fecha</label>
   <input class="form-control" size='10' maxlength='10' id='fecha' name='fecha' onblur='valida_fecha(this.id)' value='<?php echo $fecha;?>' autofocus> 
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
 <div class="col-md-2">
  <input class='btn-primary form-control' type='submit' name='accion' value='Pantalla'>
 </div>
 <div class="col-md-2">
  <input class='btn-success form-control' type='submit' name='accion' value='Excel'>
 </div>
</div>
</form>
<hr>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary text-white"><th>Pertenencia</th><th>Direcci&oacute;n<br>Operativa</th><th>Dispositivo</th><th>Plazas</th><th>Cantidad</th><th> 0 a 5 </th><th> 6 a 12 </th><th> 13 o + </th></tr>
<?php 
if(isset($_GET["fecha"])){
if($_GET["accion"]=="Excel"){Redirect("alojados_cantidades_excel?fecha=".$_GET["fecha"]."&circuito=".$_GET["circuito"]."&direccion_operativa=".$_GET["direccion_operativa"]);};
$fech=fsql($_GET["fecha"]);
$sql="select case when ong>0 then 'CONVENIADOS' else 'PROPIOS' end as perte, deno, nombre,plazas,count(*) as cantidad,
  sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")<6 then 1 else 0 end) as r5,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.") between 6 and 12 then 1 else 0 end) as r12,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")>12 then 1 else 0 end) as r13
    from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo
    left join dispositivos on admi_hogar=dispositivos.id
    left join tablas on tipo='DIOP' and valo=direccion_operativa
    where admi_alta <=".$fech." and (admi_baja is null or admi_baja>".$fech.") ";
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and  direccion_operativa=".$diop;

$sql=$sql." group by perte,deno, nombre, plazas   order by perte,deno, nombre, plazas";

$reg=registros($sql);

while($r=mysqli_fetch_assoc($reg)){

echo colorfila()."<td>".$r["perte"]."</td><td>".si($r["deno"]=="","N/A",$r["deno"])."</td><td>".$r["nombre"]."</td><td style='text-align:center;'>".$r["plazas"]."</td>"."</td><td style='text-align:center;'>".$r["cantidad"].

"</td><td style='text-align:center;'>".$r["r5"]."</td><td style='text-align:center;'>".$r["r12"]."</td><td style='text-align:center;'>".$r["r13"]."</td></tr>";

};

echo colorfila()."</tr>";

$sql="select deno , count(*) as cantidad,
  sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")<6 then 1 else 0 end) as r5,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.") between 6 and 12 then 1 else 0 end) as r12,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")>12 then 1 else 0 end) as r13
   from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo
    left join dispositivos on admi_hogar=dispositivos.id 
    left join tablas on tipo='DIOP' and valo=direccion_operativa
  where  admi_alta is not null and admi_alta<=".$fech." and (admi_baja is null or admi_baja>".$fech.") ";
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and area_gubernamental=1 and direccion_operativa=".$diop;

$sql=$sql."  group by deno   order by deno";
  
$reg=registros($sql);

$total=0;

$t5=0;

$t12=0;

$t13=0;

echo colorfila()."<td>----</td></tr>";
while($r=mysqli_fetch_assoc($reg)){

echo colorfila()."<td>Total </td><td>".si($r["deno"]=="","N/A",$r["deno"])."<td></td><td></td><td style='text-align:center;'>".$r["cantidad"].
"</td><td style='text-align:center;'>".$r["r5"]."</td><td style='text-align:center;'>".$r["r12"]."</td><td style='text-align:center;'>".$r["r13"]."</td></tr>";
$total=$total+$r["cantidad"];
$t5=$t5+$r["r5"];
$t12=$t12+$r["r12"];
$t13=$t13+$r["r13"];
};

echo colorfila()."<td>TOTAL</td><td></td><td></td><td></td><td style='text-align:center;'>".$total."</td><td style='text-align:center;'>".$t5."</td><td style='text-align:center;'>".$t12."</td><td style='text-align:center;'>".$t13."</td></tr>";
echo colorfila()."<td>----</td></tr>";




$sql="select case when ong>0 then 'CONVENIADOS' else 'PROPIOS' end as perte, count(*) as cantidad,
  sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")<6 then 1 else 0 end) as r5,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.") between 6 and 12 then 1 else 0 end) as r12,
  sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".$fech.")>12 then 1 else 0 end) as r13
   from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo
    left join dispositivos on admi_hogar=dispositivos.id 
    left join tablas on tipo='DIOP' and valo=direccion_operativa
  where   admi_alta is not null and admi_alta<=".$fech." and (admi_baja is null or admi_baja>".$fech.") ";
if($circ=="1") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=11 ";
if($circ=="2") $sql=$sql. " and area_gubernamental=1 and tipo_dispositivo=2 ";
if($diop!="0") $sql=$sql. " and area_gubernamental=1 and direccion_operativa=".$diop;

$sql=$sql." group by perte   order by perte";
  
$reg=registros($sql);

$total=0;

$t5=0;

$t12=0;

$t13=0;


while($r=mysqli_fetch_assoc($reg)){

echo colorfila()."<td>".$r["perte"]."</td><td>Total </td><td></td><td></td><td style='text-align:center;'>".$r["cantidad"].

"</td><td style='text-align:center;'>".$r["r5"]."</td><td style='text-align:center;'>".$r["r12"]."</td><td style='text-align:center;'>".$r["r13"]."</td></tr>";

$total=$total+$r["cantidad"];

$t5=$t5+$r["r5"];

$t12=$t12+$r["r12"];

$t13=$t13+$r["r13"];

};

echo colorfila()."<td>TOTAL</td><td></td><td></td><td></td><td style='text-align:center;'>".$total."</td><td style='text-align:center;'>".$t5."</td><td style='text-align:center;'>".$t12."</td><td style='text-align:center;'>".$t13."</td></tr>";



};
?>
</table>
</div>
</div>
</body>
</html>



