<?php
include("Funciones.php");
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: .");
registre();
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class="form-inline" method="get">
<div class="form-group has-warning">
<label class="label-form" for="i_desde">Desde</label>
<input class="form-control" size="10" maxlength="10" name="idesde" id="i_desde" value="<?php echo "01".substr($_SESSION['DiaHoy'],2);?>" onblur="valida_fecha(this.id)" required autofocus>
</div>
<div class="form-group has-warning">
<label class="label-form" for="i_hasta">Hasta</label>
<input class="form-control"  size="10" maxlength="10" name="ihasta" id="i_hasta" value="<?php echo $_SESSION['DiaHoy'];?>" onblur="valida_fecha(this.id)" required autofocus>
</div>
<input name="submit" type="submit" value="Consultar" />
</form>
<div class="table-responsive">
<table class="table table-striped table-bordered">
<tr class="bg-primary">
<th style='font-size:.8em'>Fecha Ped</th><th>Apellido y Nombre</th><th>Edad (hoy)</th><th style='font-size:.8em'>Derivante</th><th style='font-size:.8em'>Sit.Socio Hab.</th><th>Fecha Ges</th><th style='font-size:.8em'>Admisores</th><th>Gesti&oacute;n</th>
</tr>
<?php
if (isset($_GET["idesde"]))
{
$fini=$_GET["idesde"];
$ffin=$_GET["ihasta"];
$sql="select *, 
case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else case when admi_deriv=4 and admi_deriv_sector is not null then 
 concat(case when left(hogares_dz.deno,2)='DZ' then concat(hogares_dz.deno,'-') else '' end,hogares_dz.info,'-',case when admi_deriv_cual is null then '' else admi_deriv_cual end)
else  concat(hogares_de.deno,' ',case when admi_deriv_cual is null then '' else admi_deriv_cual end) end end as deriv ,
 hogares_proc.deno as proc, sujetos.legajo as lega,edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,sujetosActEdad,curdate()) as edad_calc from intervenciones inner join hogares_admision on inter_admision=idhogares_admision ";
$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";
$sql=$sql." left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' ";
$sql=$sql." left join tablas hogares_dz on admi_deriv_sector=hogares_dz.valo and hogares_dz.tipo='CM' ";
$sql=$sql." left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH' ";
$sql=$sql." where inter_grupo='A' and inter_fecha between ".fsql($fini)." and ".fsql($ffin)." order by inter_fecha desc";
$conn = registros($sql);
$conta=1;
while ($da = mysqli_fetch_assoc($conn)) {
  $conta=$conta+1;
  echo "<tr><td style='font-size:.8em'>".ffec($da["admi_fped"])."</td><td>".$da['Apellidos']." , ".$da['Nombres']."</td><td>".$da["edad_calc"]."</td><td style='font-size:.8em'>".$da["deriv"]."</td><td style='font-size:.8em'>".$da["proc"]."</td><td>".ffec($da["inter_fecha"])."</td>";   
  echo "<td style='font-size:.8em'>".$da["inter_oper"]."</td><td>".$da["inter_obse"]."</td></tr>";
}
};
?>
</table>
</div>
<?php if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};?>
</div>
</body>
</html>