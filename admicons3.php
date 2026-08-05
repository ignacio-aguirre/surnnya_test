<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
$hogar="";
$diop="0";
$circ="0";
if(isset($_SESSION['glhogar'])) {$hgrs="<option value='".$_SESSION['glhogar']."'>".$_SESSION['gldhogar']."</option>";} else $hgrs=str_replace('Completar','todos',$_SESSION['Opc_Hoga']);
if(isset($_GET["direccion_operativa"])){$diop=nget("direccion_operativa");};
if(isset($_GET["circuito"])){$circ=nget("circuito");};
$perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);
?>
</div>
<div class="container">
<form method="get" class="form-inline" style="font-size: 0.9em;">
 <div class="form-group has-warning">
   <label class="label-form" for="hogar">Dispositivo:</label>
   <select class="form-control" name="hogar" id="hogar" autofocus><?php echo $hgrs;?></select>
 </div>
 
 <div class="form-group has-warning">
   <label class="label-form" for="edde">Edad desde:</label>
   <input class="form-control" size="2" maxlength="2" name="edde" id="edde" value="0">
 </div>
 
 <div class="form-group has-warning">
  
   <label class="label-form" for="edha">Edad hasta:</label>
   <input class="form-control"  size="2" maxlength="2" name="edha" id="edha" value="99">
  
 </div>
 
 <div class="form-group has-warning">
  
   <label class="label-form" for="direccion_operativa">Direcci&oacute;n Operativa</label>
   <select class="form-control" id="direccion_operativa" name='direccion_operativa'>
    <option value="0">Todas</option>
    <?php echo opc_tabla("DIOP");?>
   </select>
  
  
   <label class="label-form" for="circuito">Circuito</label><select class="form-control" id="circuito" name='circuito'>
   <option value="0">Red de Hogares</option>
   <option value="1">Preingreso</option>
   <option value="2">Resid DGSAP</option>
   </select>
  
   <label class="label-form">emitir</label> 	
   <input class="btn-info form-control" name="submit" type="submit" value="Pantalla" />
   <label class="label-form">descargar</label>
   <button class="btn-success form-control" name="excel">Excel</button>
  
 </div>
</form>
<script>
seleccionar("direccion_operativa","<?php echo $diop?>");
seleccionar("circuito","<?php echo $circ?>");
</script>

<?php

if(isset($_GET['mensaje'])) echo $_GET['mensaje'];

echo "<br>";

?>

<div class="table-responsive pre-scrollable-horizontal">
<table class="table striped-table">
<tr class="bg-primary" style="font-size:.7em">
<th>Opc</th><th>Apellido y Nombre</th><th>Nro.Doc</th><th>RIB</th><th>Fecha Nac.</th><th>Edad (hoy) </th><th>Alta</th><th>Hogar</th><th>D&iacute;as</th><th>Pres.</th><th>Juzg</th><th>Def.Zonal</th><th>Medida</th></tr>
<?php
if(isset($_GET["excel"])){Redirect("admicons3_excel?hogar=".$_GET["hogar"]."&direccion_operativa=".$diop."&circuito=".$circ);};
if (isset($_GET["direccion_operativa"]))

{
$hogar=$_GET["hogar"];
$edde=$_GET["edde"];
$edha=$_GET["edha"];
echo "<script type='text/javascript'>seleccionar('hogar','".$hogar."');</script>";
if($hogar!=""){$condicion=" admi_hogar=".$hogar." and (edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) between ".$edde." and ".$edha.")";}
else{
$condicion="(edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) between ".$edde." and ".$edha.")";
if($diop!="0"){$condicion=$condicion." and  direccion_operativa=".$diop;};
if($circ=="1"){$condicion=$condicion." and area_gubernamental=1 and tipo_dispositivo=11";};
if($circ=="2"){$condicion=$condicion." and area_gubernamental=1 and tipo_dispositivo=2";};
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

if(($_SESSION['gl_admi']==1||$_SESSION['glusua']==$da['admi_usuario'])&&!isset($_SESSION['glhogar'])) echo "<a class='text-dark' href='admiedita?iid=".$da["idhogares_admision"]."'>EDI</a><br>";

         if(gettype($da["admi_baja"])=='NULL' && !isset($_SESSION['glhogar']) && $perf_original!="41") echo "<a  class='text-danger' href='admibaja?iid=".$da['idhogares_admision']."'>EGR</a>&nbsp;
         <a  class='text-primary' href='admicambio?iid=".$da['idhogares_admision']."'>CAM</a>&nbsp;";

		 if($_SESSION['gl_admi']==1) echo "<br><a class='text-success'  href='admigest?iid=".$da["idhogares_admision"]."'>GES</a>";
		 if($_SESSION['gl_super_super']==1 && $perf_original!="41") echo "<br><a  class='text-dark' href='presencialidad?id=".$da["idhogares_admision"]."'>PRE</a>";
     if(isset($_SESSION["glhogar"])) echo "<a  class='text-dark' href='talles?legajo=".$lega."'>TALLES</a>";
         echo "</td>";
         echo "<td><a href='suje_cons_duros?legajo=".$lega."'>".reemplaza($apel)." , ".$nomb."</td>";
         echo "<td>".$documento."</a></td>";
         echo "<td>".rib($da["rib_anio"],$da["rib_numero"],$da["rib_reparticion"])."</td>";
         echo "<td>".ffec($da["f_nacimiento"])."</td>";
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