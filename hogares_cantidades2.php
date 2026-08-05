<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();

$fecha=$_SESSION["DiaHoy"];

if(isset($_GET["fecha"])) $fecha=$_GET["fecha"];

?>

<div class="container">
<form class="form-inline" method='GET'>
Fecha: <input class="form-control" size='6' maxlength='8' id='fecha' name='fecha' onblur='valida_fecha(this.id)' value='<?php echo $fecha;?>'> <input type='submit' value='Consultar'>
</form>
<div class="table-responsive">
<table class="table">

<tr class="bg-primary"><th>U.T&eacute;cnica</th><th>Hogar</th><th>Cantidad</th><th> menos 6 m </th><th> 6 a 12 m </th><th> 1 a 3 as</th><th> 3 a 4 as </th><th> 5 o mas as</th></tr>

<?php 

if(isset($_GET["fecha"])){

$sql="select deno, nombre, count(*) as cantidad,
   sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).")=0 and (instr(edc(f_nacimiento,sujetosedad,SujetosMeses,sujetosactedad,@fecha),'m')=0 or convert(edc(f_nacimiento,sujetosedad,SujetosMeses,sujetosactedad,@fecha),unsigned)<6) then 1 else 0 end) as r05,
   sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).")=0 and instr(edc(f_nacimiento,sujetosedad,SujetosMeses,sujetosactedad,@fecha),'m')>0 and convert(edc(f_nacimiento,sujetosedad,SujetosMeses,sujetosactedad,@fecha),unsigned)>=6 then 1 else 0 end) as r06,
   sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).") between 1 and 2 then 1 else 0 end) as r3,
   sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).") between 3 and 6 then 1 else 0 end) as r6,
   sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).")>6 then 1 else 0 end) as r7
     from hogares_admision
     left join sujetos on admi_legajo=sujetos.legajo
     left join dispositivos on admi_hogar=dispositivos.id
     left join tablas on tipo='SUPUT' and valo=unidad_tecnica
     where admi_alta is not null and admi_alta<=".fsql($fecha)." and (admi_baja is null or admi_baja>".fsql($fecha).")
     group by deno, nombre
     order by deno, nombre";

$reg=registros($sql);

while($r=mysqli_fetch_assoc($reg)){

echo colorfila()."<td>".$r["deno"]."</td><td>".$r["nombre"]."</td><td style='text-align:center;'>".$r["cantidad"].

"</td><td style='text-align:center;'>".$r["r05"]."</td><td style='text-align:center;'>".$r["r06"]."</td><td style='text-align:center;'>".$r["r3"]."</td><td style='text-align:center;'>".$r["r6"]."</td><td style='text-align:center;'>".$r["r7"]."</td></tr>";

};

echo colorfila()."</tr>";

$sql="select 'TOTAL' as region, '' as nombre, count(*) as cantidad,
   sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).")=0 and (instr(edc(f_nacimiento,sujetosedad,SujetosMeses,sujetosactedad,@fecha),'m')=0 or convert(edc(f_nacimiento,sujetosedad,SujetosMeses,sujetosactedad,@fecha),unsigned)<6) then 1 else 0 end) as r05,
   sum(case  when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).")=0 and instr(edc(f_nacimiento,sujetosedad,SujetosMeses,sujetosactedad,@fecha),'m')>0 and convert(edc(f_nacimiento,sujetosedad,SujetosMeses,sujetosactedad,@fecha),unsigned)>=6 then 1 else 0 end) as r06,
   sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).") between 1 and 2 then 1 else 0 end) as r3,
   sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).") between 3 and 6 then 1 else 0 end) as r6,
   sum(case when edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,".fsql($fecha).")>6 then 1 else 0 end) as r7
     from hogares_admision
     left join sujetos on admi_legajo=sujetos.legajo
     left join dispositivos on admi_hogar=dispositivos.id
     where admi_alta is not null and admi_alta<=".fsql($fecha)." and (admi_baja is null or admi_baja>".fsql($fecha).")";

$r=un_registro($sql);

echo colorfila()."<td> TOTAL </td><td></td></td><td style='text-align:center;'>".$r["cantidad"].

"</td><td style='text-align:center;'>".$r["r05"]."</td><td style='text-align:center;'>".$r["r06"]."</td><td style='text-align:center;'>".$r["r3"]."</td><td style='text-align:center;'>".$r["r6"]."</td><td style='text-align:center;'>".$r["r7"]."</td></tr>";

};

?>

<table>
</div>
</div>

<script>

enfoca("fecha");

</script>

</body>

</html>



