<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Consulta Datos del NNYA y Acciones";
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: salir");
registre();
$lega= $_GET["legajo"];
if ($lega=="" ) ("Location: consultasujetos");
$fras="";
if(isset($_GET["frase"])) $fras= $_GET["frase"];
$sql="select apellidos, nombres, apodos, sujetos.legajo as lega, tipodni, sujetosdni,cuil, locparada,  lugparada, locvivienda, lugvivienda, ming1, ming2, ming3, ctex1, ctex2, ctex3,f_nacimiento, sujetosedad, sujetosmeses, sujetosactedad, edc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edad, sexo, genero, genero_cual, td.deno as td, concat(parada.descripcion,' ',parada.grupo) as loca, concat(proced.descripcion,' ',proced.grupo) as proc, 
  paises.descripcion as nacion,rib_anio, rib_numero,rib_reparticion,  usuario, sonidos, telefonos, chequeado,idg.deno as gene   from sujetos ";
$sql=$sql." left join tablas td on td.tipo='TD' and td.valo=TipoDNI ";
$sql=$sql." left join tablas idg on idg.tipo='GENER' and idg.valo=genero ";

$sql=$sql." left join localidades as parada on parada.idlocalidades=locparada";
$sql=$sql." left join localidades as proced on proced.idlocalidades=locvivienda";
$sql=$sql." left join paises on sujetos.nacionalidad=idpaises";
$sql=$sql." where sujetos.legajo=".$lega;
$dt = un_registro($sql);
$sexo="";
if($dt['sexo']=="F") $sexo="Fem.";
if($dt['sexo']=="M") $sexo="Masc.";
if($dt['sexo']=="X") $sexo="X Otros";
$fnac=ffec($dt['f_nacimiento']);
$edad=$dt['sujetosedad'];
$mese=$dt['sujetosmeses'];
$actu=ffec($dt['sujetosactedad']);
$ehoy=$dt['edad'];
$_SESSION["posicion"]="1";
include("mnu_superior.php");
?>
</div>
<script type="text/javascript">
function valida_arch() {
var desc=document.getElementById("descr");
if(desc.value=="") return false;
return true;
}
function copiarlegajo(){
navega("copiarlegajo?legajo="+"<?php echo $lega;?>");
}
</script>
<div class="container">
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr class="bg-primary text-white"><th>Apellidos</th><th>Nombres</th><th>Otros Nombres</th><th>Documento Identidad</th></tr>
</thead>
<?php $dz=un_campo("select defensoria_zonal from sujetos where legajo=".$lega);
$sector=un_campo("select deno from tablas where tipo='CM' and valo=".nulea($dz));?>
<tbody>
<tr>
<td><strong><?php echo $dt['apellidos'];?></td>
<td><strong><?php echo $dt['nombres'];?></td>
<td><strong><?php echo $dt['apodos'];?></td>
<td><strong><?php echo $dt['td'];echo " ".$dt['sujetosdni']." ".si($dt["chequeado"]==1,"CHEQUEADO","");?></td>
</tr>
</tbody>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr class="bg-primary text-white">
<th>F.Nacimiento</th><th>Edad Hoy</th><th>Nacionalidad</th><th>Sexo s/DNI</th><th>Id. de G&eacute;nero</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong><?php echo $fnac;?></strong></td>
<td><strong><?php echo $ehoy;?></strong></td>
<td><strong><?php echo $dt['nacion'];?></strong></td>
<td><strong><?php echo $sexo;?></strong></td>
<td><strong><?php echo $dt["gene"];?></strong></td>
</tr>
</thead>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr class="bg-primary text-white">
<th>&Uacute;ltima Residencia Familiar Referida</th>
</thead>
<tbody>
<tr>
<td><?php echo $dt['proc'];?></td></tr>
</tbody>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr class="bg-primary text-white"><th>Sit. Calle - Localidad</th><th>Lugar</th></tr>
</thead>
<tbody>
<tr><td><?php echo $dt['loca'];?></td><td><?php echo $dt['lugparada'];?></td></tr>
</tbody>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr class="bg-primary text-white"><th>RIB</th><th>Sector</th><th>CUIL</th></tr>
</thead>
<tbody>
<tr><td><strong><?php echo rib2($dt)."</td><td><strong>".$sector;?></td>
<td><strong><?php $cui=$dt["cuil"];echo si($cui=="","",substr($cui,0,2)."-".substr($cui,2,8)."-".substr($cui,-1))?></strong></td></tr>
</tbody>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr class="bg-primary text-white">
<th>Efector</th>
<th>Legajo</th>
<th>Estado</th>
</tr>
</thead>
<tbody>
<?php
$conn=registros("SELECT legajolocal, denominacion, dispolegajo, abierto, cerrado FROM legajos inner join sectores on dispolegajo=sectores.id where legajoUnico=".$lega);
while ( $da = mysqli_fetch_assoc($conn))
	{ 
	echo "<tr><td>".$da['denominacion']."</td><td>".$da['legajolocal']."</td><td>";
        if($da['abierto']==1) echo "Abierto";
        if($da['cerrado']==1) echo "Cerrado";
	echo "</td></tr>";
};
?>
</tbody>
</table>
</div>
<h4>Presion&aacute; <a href='sujeactidentidad?legajo=<?php echo $lega;?>'>aqu&iacute;</a> para editar datos</h4>
<h3>Archivos subidos asociados con identidad</h3>
<div class="table-responsive">
<table class="table-condensed">
<tr class="bg-primary text-white"><th>Tipo</th><th>Descripci&oacute;n</th><th>Descargar</th></tr>
<?php
$arc=registros("select tablas.deno, as_descripcion, as_path,idarchivos_subidos from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos 
left join tablas on tablas.tipo='TA' and valo=as_tipo 
where archivos_vinculos.tipo='S' and archivos_vinculos.identificador=".$lega." and left(tablas.deno,3)='IDE' order by as_fecha desc, idarchivos_subidos desc");
while($a=mysqli_fetch_assoc($arc)){
 echo "<tr><td>".$a["deno"]."</td><td>".$a["as_descripcion"]."</td><td>"."<a href='descarga_nuevo?id=".$a['idarchivos_subidos']."'>Descargar</a>"."</td></tr>";
};
?>
</table>
</div>
<h3>Historial de Acciones</h3><h4>Presion&aacute; <a href='nintervencion?lega=<?php echo $lega;?>'>aqu&iacute;</a> para registrar una Acci&oacute;n</h4>
<script>
function filtra(){
 frase=document.getElementById('fras').value;
 legajo="<?php echo $lega;?>";
 if(frase!="") navega("suje_cons_duros?legajo="+legajo+"&frase="+frase);
}
</script>
<br><br>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr class="bg-primary text-white">
<th>Efector</th><th>Fecha</th><th>D/S</th><th>Tipo</th>
<th>Instituci&oacute;n</th><th>Agente</th>
</tr>
</thead>
<tbody>
<?php
if($fras!="") $fras=" and inter_obse like '%".$fras."%'";
$sql="select 'H' as tip, nota as arch, fecha_operacion as fecha, DATE_FORMAT(`fecha_operacion`,'%w') as diasem, 
'ADMISI&Oacute;N' as ddispo, 0 as dispo,  nombre as insti, ";
$sql=$sql."'INGRESA EN HOGAR' as tipo, 0 as id,idaltasybajas as idorden, ming.deno  as obse,'' as oper";
$sql=$sql." from altasybajas left join hogares_admision on vacante=idhogares_admision left join dispositivos on hogar=dispositivos.id
  left join tablas ming on ming.tipo='HOMOI' and ming.valo=admi_moti where altasybajas.operacion='A' and  altasybajas.legajo=".$lega;
$sql=$sql." union ";
$sql=$sql." select 'H' as tip,  0 as arch, admi_fderiv as fecha, DATE_FORMAT(`admi_fderiv`,'%w') as diasem, 
'ADMISI&Oacute;N' as ddispo, 0 as dispo, nombre as insti, ";
$sql=$sql."'RECURSO ASIGNADO' as tipo, 0 as id, idhogares_admision as idorden, ming.deno as obse, '' as oper";
$sql=$sql." from hogares_admision inner join dispositivos on admi_hogar=dispositivos.id left join tablas ming on ming.tipo='HOMOI' and ming.valo=admi_moti where admi_legajo=".$lega." and admi_fderiv is not null";
$sql=$sql." union ";
$sql=$sql." select 'H' as tip,  0 as arch, admi_susp as fecha, DATE_FORMAT(`admi_susp`,'%w') as diasem, 
'ADMISI&Oacute;N' as ddispo, 0 as dispo, nombre as insti, ";
$sql=$sql."'RECURSO SUSPENDIDO' as tipo, 0 as id, idhogares_admision as idorden, admi_mots as obse, '' as oper";
$sql=$sql." from hogares_admision left join dispositivos on admi_hogar=dispositivos.id  where admi_legajo=".$lega." and admi_susp is not null";
$sql=$sql." union ";
$sql=$sql." select 'H' as tip,  0 as arch, admi_fped as fecha, DATE_FORMAT(`admi_fped`,'%w') as diasem, 
'ADMISI&Oacute;N' as ddispo, 0 as dispo,  'A DEFINIR' as insti, ";
$sql=$sql."'RECURSO PEDIDO' as tipo, 0 as id, idhogares_admision as idorden, concat(tablas_de.deno,' ',case when admi_deriv_cual is null then '' else admi_deriv_cual end)  as obse, admi_usuario as oper";
$sql=$sql." from hogares_admision left join tablas as tablas_de  on tablas_de.tipo='ADDER' and tablas_de.valo=admi_deriv where admi_legajo=".$lega." and admi_fped is not null";
$sql=$sql." union ";
$sql=$sql."select 'H' as tip,  0 as arch, fecha_operacion as fecha, DATE_FORMAT(`fecha_operacion`,'%w') as diasem, 
'ADMISI&Oacute;N' as ddispo, 0 as dispo, nombre as insti, ";
$sql=$sql."'EGRESA DE HOGAR' as tipo, 0 as id, idaltasybajas as idorden, hogares_motegreso.deno as obse, '' as oper";
$sql=$sql." from altasybajas left join hogares_admision on vacante=idhogares_admision inner join dispositivos on hogar=dispositivos.id left join tablas hogares_motegreso on hogares_motegreso.valo=admi_mote and hogares_motegreso.tipo='HOMOE' where altasybajas.operacion='B' and altasybajas.legajo=".$lega;
 $sql=$sql." union ";
 $sql=$sql."select 'H' as tip,  0 as arch, super_fecha as fecha, DATE_FORMAT(`super_fecha`,'%w') as diasem, 
 'SUPERVISI&Oacute;N' as ddispo, 0 as dispo, nombre as insti, ";
 $sql=$sql."concat('Visita Institucional ',super_super) as tipo, idsuper_visita as id, idsuper_visita as idorden, super_visita_legajo.super_obse as obse, '' as oper ";
 $sql=$sql." from super_visita left join dispositivos on super_hogar=dispositivos.id inner join super_visita_legajo on idsuper_visita=super_visita  where super_legajo=".$lega;
if($_SESSION['gldispo']!=25){
$sql=$sql." union ";
$sql=$sql."select 'I' as tip, (select count(*) from intervenciones_archivos where intervencion=idintervenciones) as arch, inter_fecha as fecha, DATE_FORMAT(`inter_fecha`,'%w') as diasem, sectores.denominacion as ddispo, inter_dispo as dispo,  salud_establecimientos.descripcion as insti, ";
$sql=$sql." tablas.deno  as tipo,  idintervenciones as id,  idintervenciones as idorden,inter_obse as obse, inter_oper as oper";
$sql=$sql." from intervenciones 
 left join sectores on inter_dispo=sectores.id
 left join salud_establecimientos on inter_hosp=idsalud_establecimientos ";
$sql=$sql." left join tablas on tablas.tipo='TINT' and valo=inter_tipo ";
$sql=$sql." where inter_dispo<>25 and ".si($_SESSION["gldispo"]==11||$_SESSION["gldispo"]==19||$_SESSION["gldispo"]==12||$_SESSION["gldispo"]==2  ," inter_legajo="," inter_tipo<>29 and inter_legajo=").$lega.$fras;
$sql=$sql." union ";
$sql=$sql."select 'I' as tip, 0 as arch, fecha as fecha, DATE_FORMAT(`fecha`,'%w') as diasem,'Gabinete de Salud' as ddispo, 0 as dispo,  
 dispositivos.nombre as insti, ";
$sql=$sql." tiposint.deno  as tipo,  0 as id,  0 as idorden,observaciones as obse, espec.deno as oper";
$sql=$sql." from es_acciones 
 left join dispositivos on dispositivo=dispositivos.id "; 
$sql=$sql." left join tablas tiposint on tiposint.tipo='ESTIA' and tiposint.valo=es_acciones.tipo ";
$sql=$sql." left join tablas espec on espec.tipo='ESESP' and espec.valo=es_acciones.especialidad ";

$sql=$sql." where legajo=".$lega.$fras;


$sql=$sql." union ";
$sql=$sql."select 'Y' as tip, archivo as arch, as_fecha as fecha, DATE_FORMAT(`as_fecha`,'%w') as diasem, sectores.denominacion as ddispo, as_dispositivo as dispo,  '' as insti, ";
$sql=$sql." 'Subida Archivo' as tipo, idarchivos_subidos as id,  1 as idorden,as_descripcion as obse, as_usuario as oper";
$sql=$sql." from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo ";
$sql=$sql." where archivos_vinculos.tipo='S' and identificador=".tsql($lega);

}
else{
$sql=$sql." union ";
$sql=$sql."select 'I' as tip, (select count(*) from intervenciones_archivos where intervencion=idintervenciones) as arch, inter_fecha as fecha, DATE_FORMAT(`inter_fecha`,'%w') as diasem, sectores.denominacion as ddispo, inter_dispo as dispo,  salud_establecimientos.descripcion  as insti, ";
$sql=$sql." tablas.deno as tipo,  idintervenciones as id,  idintervenciones as idorden,inter_obse as obse, inter_oper as oper";
$sql=$sql." from intervenciones left join salud_establecimientos on inter_hosp=idsalud_establecimientos  inner join sectores on inter_dispo=sectores.id";
$sql=$sql." left join tablas on tablas.tipo='TINT' and tablas.valo=inter_tipo";
$sql=$sql." where inter_dispo=".$_SESSION['gldispo']." and inter_legajo=".$lega.$fras;

$sql=$sql." union ";
$sql=$sql."select 'Y' as tip, archivo as arch, as_fecha as fecha, DATE_FORMAT(`as_fecha`,'%w') as diasem, sectores.denominacion as ddispo, as_dispositivo as dispo,  '' as insti, ";
$sql=$sql." 'Subida Archivo' as tipo, idarchivos_subidos as id,  1 as idorden,as_descripcion as obse, as_usuario as oper";
$sql=$sql." from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo ";
$sql=$sql." where archivos_vinculos.tipo='S' and identificador=".tsql($lega)." and as_dispositivo=".$_SESSION['gldispo'];


};
$sql=$sql." order by fecha desc, dispo, idorden ,  tip";
$conn = registros($sql);
$conta=1;
while ( $da = mysqli_fetch_assoc($conn))
 { 
     $kolor=colorfila(); 
     echo $kolor;
	 echo "<td rowspan='2'>".$da['ddispo']."</td>";
	 echo "<td>".ffec($da['fecha'])."</td>";
         $ds=$da['diasem'];
         echo "<td>";
	 if ($ds==1) echo "Lun";
	 if ($ds==2) echo "Mar";
	 if ($ds==3) echo "Mie";
	 if ($ds==4) echo "Jue";
	 if ($ds==5) echo "Vie";
	 if ($ds==6) echo "Sab";
	 if ($ds==0) echo "Dom";
         echo "</td>";
	  echo "<td>".$da['tipo']."</td>";
     echo "<td>".$da['insti']."</td><td>".$da['oper']."</td></tr>";
     echo $kolor."<td colspan='6' style='font-size:.9em;'><strong>".$da['obse']."</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
<script src="bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="generales.js?1.1"></script>
</body>
</html>