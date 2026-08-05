<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
$hogar="";
$hg=registros("select * from dispositivos where tipo_dispositivo=12 order by nombre");
$hgrs="<option></option>";
while($h=mysqli_fetch_assoc($hg)){
   $hgrs=$hgrs."<option value='".$h["id"]."'>".$h["nombre"]."</option>";
};
$perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);
?>
</div>
<div class="container">
<form method="get" class="form">
 <div class="form-group row has-warning">
  <div class="col-md-9">
   <label class="label-form" for="hogar">Hogar:</label>
   <select class="form-control" name="hogar" id="hogar" autofocus required><?php echo $hgrs;?></select>
  </div>
 </div>
 
 <div class="form-group row has-warning">
  <div class="col-md-2">
   <label class="label-form">emitir</label> 	
   <input class="btn-info form-control" name="submit" type="submit" value="Pantalla" />
  </div>
  <div class="col-md-2">
   <label class="label-form">descargar</label>
   <button class="btn-success form-control" name="excel">Excel</button>
  </div>
 </div>
</form>
<script>
</script>

<?php

if(isset($_GET['mensaje'])) echo $_GET['mensaje'];

echo "<br>";

?>

<div class="table-responsive pre-scrollable-horizontal">
<table class="table striped-table">
<tr class="bg-primary" style="font-size:.7em">
<th>Opc</th><th>Apellido y Nombre</th><th>Nro.Doc</th><th>RIB</th><th>Edad (hoy) </th><th>Alta</th><th>Hogar</th><th>D&iacute;as</th><th>Pres.</th><th>Juzg</th><th>Def.Zonal</th><th>Medida</th></tr>
<?php
if(isset($_GET["excel"])){Redirect("alojados_preegreso_excel?hogar=".$_GET["hogar"]);};
if (isset($_GET["hogar"]))

{
$hogar=$_GET["hogar"];
echo "<script type='text/javascript'>seleccionar('hogar','".$hogar."');</script>";
if($hogar!=""){$condicion=" admi_hogar=".$hogar;}
else{
$condicion=" direccion_operativa=".$diop." and tipo_dispositivo=12";
};
      $sql="select *,
       edc(admi_alta,null,null,null,case when admi_baja is null then curdate() else admi_baja end) as dias, 
       sujetos.legajo , sujetosDNI, Apellidos, Nombres, sexo, 
       edc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad,
       tdef.deno as dezo,tstd.deno as tdoc,
       utec.deno as unidad,
       pres.deno as presencia,
       case when edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate())<18 then 
           case when tipo_medida=92 then 'No Innovar' else
        case when tipo_medida=93 then 'Adoptabilidad' else 
         (select max(date_add(fecha, interval dias day)) from sujetos_medidas where sujetos_medidas.legajo=sujetos.legajo) end end
       else 'Mayor Edad' end as medida  , rib_anio, rib_numero, rib_reparticion 
       from hogares_admision  ";
	$sql=$sql." left join dispositivos on admi_hogar=dispositivos.id  left join sujetos on admi_legajo=sujetos.legajo  left join tablas tstd on tstd.valo=sujetos.TipoDNI and tstd.tipo='TD' left join sujetos_juridicos on admi_legajo=sujetos_juridicos.legajo ";
     	$sql=$sql." left join tablas tdef on tdef.valo=sujetos.defensoria_zonal and tdef.tipo='CM'";
     	$sql=$sql." left join tablas mote on mote.valo=admi_mote and mote.tipo='HOMOE'";
     	$sql=$sql." left join tablas utec on utec.valo=unidad_tecnica and utec.tipo='SUPUT'";
     	$sql=$sql." left join tablas pres on pres.valo=presencialidad and pres.tipo='EPRE'";
	$sql=$sql." where ".$condicion." and admi_alta is not null ";
        $sql=$sql." and admi_baja is null";
       	$sql=$sql." order by  utec.deno, nombre, Apellidos, Nombres";

	$conn = registros($sql);
	$conta=1;
	while ($da = mysqli_fetch_assoc($conn)) {
         $conta=$conta+1;
         $lega=$da['legajo'];
         $apel=$da["Apellidos"];
	 $nomb= $da["Nombres"];
         $documento=$da["tdoc"]." ".$da["SujetosDNI"];
         echo "<tr style='font-size:.7em;'><td>";

         if(gettype($da["admi_baja"])=='NULL' && !isset($_SESSION['glhogar']) && $perf_original!="41") echo "<a  class='text-danger' href='alprebaja?id=".$da['idhogares_admision']."'>EGRESO</a></td>";
         echo "<td><a href='consultaunsujeto=?vlegajo=".$lega."'>".reemplaza($apel)." , ".$nomb."</td>";
         echo "<td>".$documento."</a></td>";
         echo "<td>".rib($da["rib_anio"],$da["rib_numero"],$da["rib_reparticion"])."</td>";
         echo "<td>".$da["edad"]."</td>";
         echo "<td>".ffec($da["admi_alta"])."</td>";	
         echo "<td>".$da["nombre"]."</td>";
         echo "<td>".$da["dias"]."</td>";
         echo "<td>".$da["presencia"]."<br>".ffec($da["fecha_presencialidad"])."</td>";
         echo "<td>".$da["juzgado_numero"]."</td>";
         echo "<td>".$da["dezo"]."</td>";
         echo "<td>".si($da["medida"]=="Mayor Edad","Mayor Edad",si($da["medida"]=="No Innovar","No Innovar",si($da["medida"]=="Adoptabilidad","Adoptabilidad","<a href='descargamedida?legajo=".$lega."'>".ffec($da["medida"]))."</a>"))."</td>";
         echo "</tr>";};	

echo "</table>";

if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};



};

echo "</table>";

 ?>


</div>
</div>

</body>

</html>