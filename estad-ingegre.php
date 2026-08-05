<?php
include("Funciones.php");
session_start();
include("encabezado.php");
registre();

?>

<script type="text/javascript"> 

function valida_datos() {

var fini=document.getElementById("fini").value;

var ffin=document.getElementById("ffin").value;

if(fini==""|ffin=="") return false;

return true;

}

</script>

<?php
$fini="01/01/".substr($_SESSION['DiaHoy'],6);
$ffin=$_SESSION['DiaHoy'];
$soco="";
$inpa="";
if(isset($_GET['fini'])) {$fini=$_GET['fini'];$ffin=$_GET['ffin'];if(isset($_GET['isoco'])) $soco=$_GET['isoco'];if(isset($_GET['iinpa'])) $inpa=$_GET['iinpa'];};
$sino="<option value=1>Si</option><option value=0>No</option>";
?>
<div class="container">
<form class="form-inline" method="GET" onsubmit='return valida_datos()'>
<div class="form-group has-warning">
 <label class="label-form" for="fini">Filtros: Fechas desde y hasta</label>
 <input class="form-control" type='text' name='fini' id='fini' maxlength='10' size='10' onblur='valida_fecha("fini")' value='<?php echo $fini;?>'>
 <input class="form-control" type='text' name='ffin' id='ffin' maxlength='10' size='10' onblur='valida_fecha("ffin")' value='<?php echo $ffin;?>'>
</div>
<div class="form-group has-warning">
<label class="label-form" for="soco">S&oacute;lo Conveniados</label><input class="form-control" type='checkbox' name='isoco' id='soco' value='SI' checked>
</div>
<div class="form-group has-warning">
<label class="label-form" for="inpa">Incluir Paradores</label><input class="form-control" type='checkbox' name='iinpa' id='inpa' value='SI'>
</div>
<input type="submit" value="Emitir">
<script type="text/javascript">
enfoca("fini");
document.getElementById("soco").checked=(<?php if($soco=="SI") {echo "true";} else echo "false";?>);
document.getElementById("inpa").checked=(<?php if($inpa=="SI") {echo "true";} else echo "false";?>);
</script> 
</form>

Ingresos en el per&iacute;odo
<div class="table-responsive">
<table class="table">

<th>0 a 3</th><th>4 a 12</th><th>> 12</th><th>S/D</th><th>Total</th>

<?php

$cond="";

if($soco=="SI") { $cond=" and conveniado=1  ";}

 else

{

  if($inpa=="SI") {$cond=" and  true ";} else {$cond=" and modalidad<>5 ";};

};



$sql="select sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta)<4  then 1 else 0 end) as e03, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta) between 4 and 12 then 1 else 0 end) as e412, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta)>12  then 1 else 0 end) as ms12, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta) is null then 1 else 0 end) as sdat, count(*) as tota from hogares_admision ";

$sql=$sql." inner join sujetos on admi_legajo=sujetos.legajo ";

$sql=$sql." left join dispositivos on dispositivos.id=admi_hogar ";

$sql=$sql." where (admi_moti not in (5,19) and admi_alta between ".fsql($fini)." and ".fsql($ffin).")";

$sql=$sql.$cond;

$at = un_registro($sql);

echo "<tr bgcolor='white'>";

echo "<td>".$at["e03"]."</td><td>".$at["e412"]."</td><td>".$at["ms12"]."</td><td>".$at["sdat"]."</td><td>".$at["tota"]."</td>";

echo "</tr>";

?>

</table></div>
Egresos en el per&iacute;odo
<div class="table-responsive">
<table class="table">
<th>0 a 3</th><th>4 a 12</th><th>> 12</th><th>S/D</th><th>Total</th>
<?php
$sql="select sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja)<4  then 1 else 0 end) as e03, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 4 and 12 then 1 else 0 end) as e412, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja)>12  then 1 else 0 end) as ms12, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) is null then 1 else 0 end) as sdat, count(*) as tota from hogares_admision ";

$sql=$sql." inner join sujetos on admi_legajo=sujetos.legajo ";

$sql=$sql." left join dispositivos on dispositivos.id=admi_hogar ";

$sql=$sql." where (admi_mote not in (4,23) and admi_baja between ".fsql($fini)." and ".fsql($ffin).")";

$sql=$sql.$cond;

$bt = un_registro($sql);

echo "<tr bgcolor='white'>";

echo "<td>".$bt["e03"]."</td><td>".$bt["e412"]."</td><td>".$bt["ms12"]."</td><td>".$bt["sdat"]."</td><td>".$bt["tota"]."</td>";

echo "</tr>";

?>

</table></div>

</div>


<br>
Egresos por Motivo
<div class="table-responsive">
<table class="table">
<th>Motivo de Egreso</th><th> - 1 </th><th>1 a 3</th><th>4 a 6</th><th>7 a 9</th><th>10 a 12</th><th>13 a 15</th><th>16 a 18</th><th>19 o +</th><th>S/D</th><th>Total</th>
<?php

$sql="select case when admi_mote in (8,14,22) then 'Salud' else case when admi_mote in (9,17) then 'Autovalimiento' else deno end end  as denom, 

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja)<1  then 1 else 0 end) as e01, 

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 1 and 3 then 1 else 0 end) as e03,

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 4 and 6 then 1 else 0 end) as e06,

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 7 and 9 then 1 else 0 end) as e09,

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 10 and 12 then 1 else 0 end) as e12,

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 13 and 15 then 1 else 0 end) as e15,

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 16 and 18 then 1 else 0 end) as e18,

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja)>18  then 1 else 0 end) as ms18, 

sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) is null then 1 else 0 end) as sdat, 

count(*) as tota 

from hogares_admision inner join sujetos on admi_legajo=sujetos.legajo left join tablas on tipo='HOMOE' and valo=admi_mote ";

$sql=$sql." left join dispositivos on dispositivos.id=admi_hogar ";

$sql=$sql." where (admi_mote not in (4,23) and admi_baja between ".fsql($fini)." and ".fsql($ffin).")";

$sql=$sql.$cond;

$sql=$sql." group by denom order by denom";



$conn = registros($sql);

$conta=1;

while ($dt = mysqli_fetch_assoc($conn)) {

 $conta=$conta+1;

 if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};

 echo "<td>".$dt["denom"]."</td><td>".$dt["e01"]."</td><td>".$dt["e03"]."</td><td>".$dt["e06"]."</td><td>".$dt["e09"]."</td><td>".$dt["e12"]."</td><td>".$dt["e15"]."</td><td>".$dt["e18"]."</td><td>".$dt["ms18"]."</td><td>".$dt["sdat"]."</td><td>".$dt["tota"]."</td><td></td>";



 echo "</tr>";



};

?>
</table>
</div>
<br>
NNYA sin edad calculable
<div class="table-responsive">
<table class="table">
<th>Apellido y Nombre</th><th>Hogar</th>
<?php
$sql="select distinct sujetos.legajo as lega, apellidos, nombres, nombre from hogares_admision inner join sujetos on admi_legajo=sujetos.legajo left join dispositivos on admi_hogar=dispositivos.id where (edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) is null and admi_alta is not null and  diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")>0 )";
$sql=$sql.$cond;
$sql=$sql." order by apellidos, nombres";
$conn = registros($sql);
while ($dt = mysqli_fetch_assoc($conn)) {
 echo "<tr><td>".$dt["apellidos"]." , ".$dt["nombres"]."</td><td>".$dt["nombre"]."</td>";
 echo "</tr>";
};
?>
</table>
</div>


</div>

</body>

</html>

