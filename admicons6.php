<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
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
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
$soco="";
if(isset($_GET['fini'])) {$fini=$_GET['fini'];$ffin=$_GET['ffin'];if(isset($_GET['isoco'])) $soco=$_GET['isoco'];};
$sino="<option value=1>Si</option><option value=0>No</option>";
?>

<div class="container">
<form class="form-inline" method="GET" onsubmit='return valida_datos()'>
<fieldset>
<label>Filtros: Fechas desde y hasta</label>
<input type='text' name='fini' id='fini' maxlength='10' size='10' onblur='valida_fecha("fini")' value='<?php echo $fini;?>'>
<input type='text' name='ffin' id='ffin' maxlength='10' size='10' onblur='valida_fecha("ffin")' value='<?php echo $ffin;?>'>
<br>
S&oacute;lo Conveniados<input type='checkbox' name='isoco' id='soco' value='SI' checked>

<input class="btn btn-primary" type="submit" value="Emitir">
</fieldset>
</form>

<script type="text/javascript">

enfoca("fini");

document.getElementById("soco").checked=(<?php if($soco=="SI") {echo "true";} else echo "false";?>);



</script> 



<div style="position: absolute; top:200px; left:20px; max-height:700px; max-width:650px;overflow:auto;" >

<?php

$d = un_registro("select datediff(".fsql($ffin).",".fsql($fini).")+1 as b");

?>

<table>

<th>U.T&eacute;cnica</th><th>Hogar</th><th>Ingresos</th><th>Egresos</th><th>Chicos</th><th>DsxCh</th><th>ChxDia</th>

<?php

$cond="";

if($soco=="SI") {
  $cond=" and conveniado=1 ";} 
else {$cond=" and conveniado=1 ";
};

 



$cond=$cond. " and true and direccion_operativa in(1,2) ";

$sql="select '1' as orden, deno, nombre, sum(case when admi_alta between ".fsql($fini)." and ".fsql($ffin)."  then 1 else 0 end) as altas, sum(case when admi_baja between ".fsql($fini)." and ".fsql($ffin)."  then 1 else 0 end) as bajas, count(distinct admi_legajo) as chicos, sum(diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")) as dias 
from hogares_admision left join dispositivos on dispositivos.id=admi_hogar 
left join tablas on tipo='SUPUT' and valo=unidad_tecnica where admi_alta is not null and diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")>0 ";
$sql=$sql.$cond;
$sql=$sql."group by orden, deno,  nombre  having altas+bajas+chicos>0 ";

$sql=$sql." union select '2' as orden, null as deno, 'TOTAL' as nombre, sum(case when admi_alta between ".fsql($fini)." and ".fsql($ffin)."  then 1 else 0 end) as altas, sum(case when admi_baja between ".fsql($fini)." and ".fsql($ffin)."  then 1 else 0 end) as bajas, count(distinct admi_legajo) as chicos,sum(diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")) as dias from hogares_admision left join dispositivos on dispositivos.id=admi_hogar where admi_alta is not null and diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")>0 ";

$sql=$sql.$cond;

$sql=$sql." order by orden, deno, nombre ";

$conn = registros($sql);

$conta=1;

while ($dt = mysqli_fetch_assoc($conn)) {

 $conta=$conta+1;

 if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};

 echo "<td>".$dt["deno"]."</td><td>".$dt["nombre"]."</td><td>".$dt["altas"]."</td><td>".$dt["bajas"]."</td><td>".$dt["chicos"]."</td><td>".round($dt["dias"]/$dt["chicos"],0)."</td><td>".round($dt["dias"]/$d["b"],2)."</td>";

 echo "</tr>";

};

?>

</table>

</div>

<div style="position: absolute; top:250px; left:700px; heigth:100px; max-heigth:100px; overflow:auto;" >

Ingresos en el per&iacute;odo
<div class="table-responsive">
<table class="table">

<tr><th>0 a 5</th><th>6 a 12</th><th> 13 o +</th><th>S/D</th><th>Total</th></tr>

<?php



$sql="select sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta)<6  then 1 else 0 end) as e05, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta) between 6 and 12 then 1 else 0 end) as e612, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta)>12  then 1 else 0 end) as ms12, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta) is null then 1 else 0 end) as sdat, count(*) as tota from hogares_admision ";

$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";

$sql=$sql." left join dispositivos on dispositivos.id=admi_hogar ";

$sql=$sql." where admi_alta between ".fsql($fini)." and ".fsql($ffin);

$sql=$sql.$cond;

$at = un_registro($sql);

echo "<tr bgcolor='white'>";

echo "<td>".$at["e05"]."</td><td>".$at["e612"]."</td><td>".$at["ms12"]."</td><td>".$at["sdat"]."</td><td>".$at["tota"]."</td>";

echo "</tr>";

?>

</table>
</div>

Egresos en el per&iacute;odo
<div class="table-responsive">
<table class="table">

<tr><th>0 a 5</th><th>6 a 12</th><th> 13 o +</th><th>S/D</th><th>Total</th></tr>

<?php

$sql="select sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja)<6  then 1 else 0 end) as e05, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 6 and 12 then 1 else 0 end) as e612, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja)>12  then 1 else 0 end) as ms12, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) is null then 1 else 0 end) as sdat, count(*) as tota from hogares_admision ";

$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo  ";

$sql=$sql." left join dispositivos on dispositivos.id=admi_hogar ";

$sql=$sql." where admi_baja between ".fsql($fini)." and ".fsql($ffin);

$sql=$sql.$cond;

$bt = un_registro($sql);

echo "<tr bgcolor='white'>";

echo "<td>".$bt["e05"]."</td><td>".$bt["e612"]."</td><td>".$bt["ms12"]."</td><td>".$bt["sdat"]."</td><td>".$bt["tota"]."</td>";

echo "</tr>";

?>

</table>
</div>



<!--div style="position: absolute; top:400px; left:700px; heigth:600px; max-height:600px; overflow:auto;" -->

Ingresos por Motivo
<div class="table-responsive">
<table class="table">

<tr><th>Motivo de Ingreso</th><th>0 a 5</th><th>6 a 12</th><th>13 o +</th><th>S/D</th><th>Total</th></tr>

<?php 
$sql="select deno, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta)<6  then 1 else 0 end) as e05, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta) between 6 and 12 then 1 else 0 end) as e612, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta)>12  then 1 else 0 end) as ms12, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_alta) is null then 1 else 0 end) as sdat, count(*) as tota from hogares_admision left join sujetos on admi_legajo=sujetos.legajo left join tablas ming on ming.tipo='HOMOI' and ming.valo=admi_moti";
$sql=$sql." left join dispositivos on dispositivos.id=admi_hogar ";
$sql=$sql." where admi_alta between ".fsql($fini)." and ".fsql($ffin);
$sql=$sql.$cond;
$sql=$sql." group by deno order by deno";

$conn = registros($sql);



while ($dt = mysqli_fetch_assoc($conn)) {
 echo "<tr><td>".$dt["deno"]."</td><td>".$dt["e05"]."</td><td>".$dt["e612"]."</td><td>".$dt["ms12"]."</td><td>".$dt["sdat"]."</td><td>".$dt["tota"]."</td></tr>";

};

?>

</table>
</div>

Egresos por Motivo
<div class="table-responsive">
<table class="table">

<tr><th>Motivo de Egreso</th><th>0 a 5</th><th>6 a 12</th><th>13 o +</th><th>S/D</th><th>Total</th></tr>
<?php
$sql="select deno, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja)<6  then 1 else 0 end) as e05, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) between 6 and 12 then 1 else 0 end) as e612, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja)>12  then 1 else 0 end) as ms12, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,admi_baja) is null then 1 else 0 end) as sdat, count(*) as tota from hogares_admision left join sujetos on admi_legajo=sujetos.legajo left join tablas on valo=admi_mote and tipo='HOMOE' ";
$sql=$sql." left join dispositivos on dispositivos.id=admi_hogar ";
$sql=$sql." where admi_baja between ".fsql($fini)." and ".fsql($ffin);
$sql=$sql.$cond;
$sql=$sql." group by deno order by deno";
$conn = registros($sql);
while ($dt = mysqli_fetch_assoc($conn)) {
 echo "<tr><td>".$dt["deno"]."</td><td>".$dt["e05"]."</td><td>".$dt["e612"]."</td><td>".$dt["ms12"]."</td><td>".$dt["sdat"]."</td><td>".$dt["tota"]."</td></tr>";

};

?>

</table>
</div>
NNYA Alojados por Sexo
<div class="table-responsive">
<table class="table">
<tr><th>Fem</th><th>Mas</th><th> X </th><th>Total</th></tr>
<?php $r=un_registro("select sum(case when sexo='F' then 1 else 0 end) as fem,sum(case when sexo='M' then 1 else 0 end) as mas,sum(case when sexo='X' then 1 else 0 end) as xes,count(*) as tot from sujetos where legajo in (select distinct admi_legajo from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where admi_alta is not null and diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")>0 ".$cond.")");
echo "<tr><td>".$r["fem"]."</td><td>".$r["mas"]."</td><td>".$r["xes"]."</td><td>".$r["tot"]."</td></tr>";
?>
</table>
</div>
NNYA Alojados por rango etario
<div class="table-responsive">
<table class="table">
<tr><th>0 a 5</th><th>6 a 12</th><th>13 o +</th><th>S/D</th><th>Total</th></tr>
<?php $r=un_registro("select sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,".fsql($ffin).")<6  then 1 else 0 end) as e05, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,".fsql($ffin).") between 6 and 12 then 1 else 0 end) as e612, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,".fsql($ffin).")>12  then 1 else 0 end) as ms12, sum(case when edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,".fsql($ffin).") is null then 1 else 0 end) as sdat, count(*) as tota from sujetos 
   where sujetos.legajo in (select distinct admi_legajo from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where admi_alta is not null and diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")>0 ".$cond.")");
echo "<tr><td>".$r["e05"]."</td><td>".$r["e612"]."</td><td>".$r["ms12"]."</td><td>".$r["sdat"]."</td><td>".$r["tota"]."</td></tr>";
?>
</table>
</div>
NNYA Alojados por edad
<div class="table-responsive">
<table class="table">
<tr><th>Edad <?php echo $ffin?></th><th>Cantidad</th></tr>
<?php $reg=registros("select edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,".fsql($ffin).") as eda, count(*) as tot from sujetos 
    where sujetos.legajo in (select distinct admi_legajo from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where admi_alta is not null and diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")>0 ".$cond.") group by eda");
   while ($r = mysqli_fetch_assoc($reg)) {
    echo "<tr><td>".$r["eda"]."</td><td>".$r["tot"]."</td></tr>";
   };
?>
</table>
</div>


NNYA Alojados por Grupo Hermanos
<div class="table-responsive">
<table class="table">
<tr><th>Grupo Hermanos</th><th>Cantidad</th></tr>
<?php $reg=registros("select grupos.apellidos, count(*) as tot from sujetos 
   left join grupos_legajos on sujetos.legajo=grupo_legajo 
   left join grupos on idgrupos=grupos_legajos.grupo
   where sujetos.legajo in 
   (select distinct admi_legajo from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where admi_alta is not null and diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")>0 "
     .$cond.") group by grupos.apellidos");
   while ($r = mysqli_fetch_assoc($reg)) {
    echo "<tr><td>".$r["apellidos"]."</td><td>".$r["tot"]."</td></tr>";
   };
?>

</table>
</div>


</div>

<div style="position: absolute; top:900px; left:20px; max-height:700px; overflow:auto;" >

Chicos sin edad calculable

<table>

<th>Legajo</th><th>Apellidos</th><th>Nombres</th>

<?php

$sql="select distinct sujetos.legajo as lega, apellidos, nombres, nombre from hogares_admision left join sujetos on admi_legajo=sujetos.legajo  left join dispositivos on admi_hogar=dispositivos.id where edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) is null and admi_alta is not null and  diasentre(admi_alta,admi_baja,".fsql($fini).",".fsql($ffin).")>0 ";

$sql=$sql.$cond;

$sql=$sql." order by apellidos, nombres";

$conn = registros($sql);

$conta=1;

while ($dt = mysqli_fetch_assoc($conn)) {

 $conta=$conta+1;

 if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};

 echo "<td>".$dt["apellidos"]."</td><td>".$dt["nombres"]."</td><td>".$dt["nombre"]."</td>";

 echo "</tr>";

};

?>

</table>



</div>

</body>

</html>

