<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
$hogar="";
$dis=registros("select id, nombre from dispositivos where tipo_dispositivo=1 and baja is null order by nombre");
$disp="<option value=''>Todos</option>";
while($d=mysqli_fetch_assoc($dis)){
   $disp=$disp."<option value='".$d["id"]."'>".$d["nombre"]."</option>";
};
?>
</div>
<div class="container">
<form method="get" class="form-inline">
<div class="form-group has-warning">
<label class="label-form" for="dispositivo">Dispositivo:</label>
<select class="form-control" name="dispositivo" id="dispositivo" autofocus><?php echo $disp;?></select>&nbsp;
</div>
<input class="btn-info" name="submit" type="submit" value="Consultar" />&nbsp;
<button class="btn-success" name="excel">Excel</button>
</form>

<div class="table-responsive pre-scrollable-horizontal">
<table class="table striped-table">
<tr class="bg-primary" style="font-size:.8em">
<th>Opc</th><th>Apellido y Nombre</th><th>Edad (hoy)</th><th>Alta</th><th>Dispositivo</th><th>Familia</th><th>D&iacute;as</th><th>Juzg</th><th>Def.Zonal</th><th>Medida</th></tr>
<?php
if(isset($_GET["excel"])){Redirect("af_nnya_hoy_excel?dispositivo=".$_GET["dispositivo"]);};
if(isset($_GET["submit"])){
 $hogar=$_GET["dispositivo"];
echo "<script type='text/javascript'>seleccionar('dispositivo','".$hogar."');</script>";

       $sql="select *, dispositivos.nombre as dispositivo, af_familias.denominacion  as familia, 
       edc(admi_alta,null,null,null,case when admi_baja is null then curdate() else admi_baja end) as dias, 
       sujetos.legajo , Apellidos, Nombres, 
       edc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad,
       tdef.deno as dezo,
       case when edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate())<18 then 
           case when tipo_medida=92 then 'No Innovar' else
        case when tipo_medida=93 then 'Adoptabilidad' else 
         (select max(date_add(fecha, interval dias day)) from sujetos_medidas where sujetos_medidas.legajo=sujetos.legajo) end end
       else 'Mayor Edad' end as medida  , rib_anio, rib_numero, rib_reparticion 
       from hogares_admision  
       left join dispositivos on admi_hogar=dispositivos.id  
       left join sujetos on admi_legajo=sujetos.legajo  
       left join sujetos_juridicos on admi_legajo=sujetos_juridicos.legajo
       left join tablas tdef on tdef.valo=sujetos.defensoria_zonal and tdef.tipo='CM'
       left join af_familias on admi_fami=idaf_familias 
       where admi_alta is not null and admi_baja is null and tipo_dispositivo=1 ";
       if($hogar!='')  $sql=$sql." and admi_hogar=".$hogar;
       $sql=$sql." order by  nombre,af_familias.denominacion, Apellidos, Nombres";
       $conn = registros($sql);
       $conta=1;
       while ($da = mysqli_fetch_assoc($conn)) {
         $conta=$conta+1;
         $lega=$da['legajo'];
         $apel=$da["Apellidos"];
	 $nomb= $da["Nombres"];
	 $cntapy=un_campo("select count(*) from af_apoyos where alojamiento=".$da["idhogares_admision"]." and f_hasta is null");	

         echo "<tr style='font-size:.8em;'><td>";
         echo " EGR<a href='admibaja?iid=".$da['idhogares_admision']."'><img height='15' width='15' src='imagenes/flecha.png'></a>
 <a href='af_apoyos?id=".$da['idhogares_admision']."'>APY</a>(".$cntapy.")";

         echo "</td>";
         echo "<td><a href='consultaunsujeto?vlegajo=".$lega."'>".reemplaza($apel).", ".$nomb."</a></td>";
         echo "<td>".$da["edad"]."</td>";
         echo "<td>".ffec($da["admi_alta"])."</td>";	
         echo "<td>".$da["dispositivo"]."</td>";
         echo "<td>".$da["familia"]."</td>";
         echo "<td>".$da["dias"]."</td>";
         echo "<td>".$da["juzgado_numero"]."</td>";
         echo "<td>".$da["dezo"]."</td>";
         echo "<td>".si($da["medida"]=="Mayor Edad","Mayor Edad",si($da["medida"]=="No Innovar","No Innovar",si($da["medida"]=="Adoptabilidad","Adoptabilidad","<a href='descargamedida?legajo=".$lega."'>".ffec($da["medida"]))."</a>"))."</td>";
         echo "</tr>";
       };

echo "</table>";
if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};
};
?>


</div>
</div>

</body>

</html>