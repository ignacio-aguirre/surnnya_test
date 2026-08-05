<?php
include("Funciones.php");
session_start();
if (!isset($_SESSION['gldispo'])) Redirect ("salir");
registre();
$cate="";
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
$opca=str_replace("Completar","Todas",$_SESSION["Opc_Hoga_Cate"]);
$opcd=tbla("derivantes_admision");
$opcp=str_replace("Completar","Todas",$_SESSION["Opc_Hoga_Proc"]);
$opcm=str_replace("Completar","Todos",$_SESSION["Opc_Hoga_Ming"]);
include("encabezado-test.php");
?>



<div class="container">
<form class="form" enctype="multipart/form-data">
<label>Desde/Hasta</label><input type="text" name="fini" size="10" maxlength="10" id="fini" onblur="valida_fecha('fini')" value="<?php echo $fini;?>"> 
<input type="text" name="ffin" size="10" maxlength="10" id="ffin" onblur="valida_fecha('ffin')" value="<?php echo $ffin;?>"> 
<label>Categor&iacute;as</label><select name="icate" id="i_cate"><?php echo $opca;?></select>
<label>Derivantes</label><select name="ideriv" id="i_deriv"><?php echo $opcd;?></select><br>
<label>Sit.SocioHab.</label><select name="iproc" id="i_proc"><?php echo $opcp;?></select>
<label>Motivo de Ingreso</label><select name="imoti" id="i_moti"><?php echo $opcm;?></select><br>
<input name="submit" type="submit" value="Consultar" />
</form>

<script type="text/javascript">enfoca("i_cate");</script> 
<div class="table-responsive">
<table class="table table-striped table-bordered">
<tr style="font-size:.7em">
<th>F.Pedido</th><th>Apellido y Nombre</th><th>Fecha Nac.</th><th>Edad (hoy)</th><th>Categor&iacute;a</th><th>Solicitante</th><th>Sit.Soc.Hab.</th><th>Motivo Ingreso</th><th>Estado</th><th>Fecha</th><th>Hogar</th>



<?php

if (isset($_GET["icate"]))

{

 $cate=$_GET["icate"];

 $deri=$_GET["ideriv"];

 $proc=$_GET["iproc"];

 $moti=$_GET["imoti"];

 $fini=$_GET["fini"];

 $ffin=$_GET["ffin"];

 echo "<script type='text/javascript'>
document.getElementById('fini').value='".$fini."';
document.getElementById('ffin').value='".$ffin."';
seleccionar('i_cate','".$cate."');seleccionar('i_deriv','".$deri."');seleccionar('i_proc','".$proc."');seleccionar('i_moti','".$moti."');
</script>";



 $sql="select *, sujetos.legajo , sujetosDNI, Apellidos, Nombres, 
  edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad_calc, 
  case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else case when admi_deriv=4 and admi_deriv_sector is not null then 
 concat(case when left(hogares_dz.deno,2)='DZ' then concat(hogares_dz.deno,'-') else '' end,hogares_dz.info,'-',case when admi_deriv_cual is null then '' else admi_deriv_cual end )
else  concat(hogares_de.deno,' ',case when admi_deriv_cual is null then '' else admi_deriv_cual end  ) end end as deriv ,  
  hogares_proc.deno as ssha, ming.deno as moti, hogares_ca.deno as cate, 
 case when tipo_dispositivo=1 then concat('AF: ',af_familias.denominacion) else nombre end as hogar, ";
 $sql=$sql."case when admi_alta is not null then 'ALTA' else case when admi_susp then 'SUSPENDIDO' else case when admi_fderiv is not null then 'ASIGNADO' else 'PENDIENTE' end end end as estado,";

 $sql=$sql."case when admi_alta is not null then admi_alta else case when admi_susp then admi_susp else case when admi_fderiv is not null then admi_fderiv else null end end end as fecha ";
 $sql=$sql." from hogares_admision  ";
 $sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";
 $sql=$sql." left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' ";
 $sql=$sql." left join tablas hogares_dz on admi_deriv_sector=hogares_dz.valo and hogares_dz.tipo='CM' ";
 $sql=$sql." left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' ";
 $sql=$sql." left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH' ";
 $sql=$sql." left join tablas ming on ming.tipo='HOMOI' and admi_moti=ming.valo ";

 $sql=$sql." left join dispositivos on admi_hogar=dispositivos.id ";

 $sql=$sql." left join af_familias on admi_fami=idaf_familias ";

 $sql=$sql." where admi_fped between ".fsql($fini)." and ".fsql($ffin);

 if ($cate!="") $sql=$sql." and admi_cate=".$cate; 

 if ($deri!="-1") $sql=$sql." and admi_deriv=".$deri; 

 if ($proc!="") $sql=$sql." and admi_proc=".$proc; 

 if ($moti!="") $sql=$sql." and admi_moti=".$moti; 



$sql=$sql." order by  admi_fped, idhogares_admision "; 

 $estados=[];
 $cantidades=[];

 $conn = registros($sql);

 $conta=1;

 while ($da = mysqli_fetch_assoc($conn)) {

  if ($cate==""||$da['admi_cate']==$cate) {

    $conta=$conta+1;

    

    $lega=$da['legajo'];

    $apel=$da["Apellidos"];

    $nomb= $da["Nombres"];

    $documento=$da["deno"]." ".$da["SujetosDNI"];

    if(gettype($da["SujetosDNI"])=="NULL") $documento="Leg. ".$lega;

    echo "<tr style='font-size:.7em'><td>".ffec($da["admi_fped"]);

    echo "<td><a href='consultaunsujeto?vlegajo=".$lega."'>".$apel." , ".$nomb."</a></td>";

    echo "<td>".ffec($da["f_nacimiento"])."</td><td>".$da["edad_calc"]."</td>";

    echo "<td>".$da["cate"]."</td>";	

    echo "<td>".$da["deriv"]."</td>";	

    echo "<td>".$da["ssha"]." ".$da["admi_proc_cual"]."</td>";

    echo "<td>".substr($da["moti"],0,15)."</td>";

    echo "<td>".$da["estado"]."</td>";

    echo "<td>".ffec($da["fecha"])."</td>";

    echo "<td>".$da["hogar"]."</td>";

    echo "</tr>";
    if(array_search($da["estado"],$estados)===false){
    	array_push($estados,$da["estado"]);
	array_push($cantidades,1);
    }
    else{
	$ind=array_search($da["estado"],$estados);
	$cantidades[$ind]=$cantidades[$ind]+1;
    };	
    };};	
    
	

};



?>

</table>

<?php if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros <br>';
for($i=0;$i<count($estados);$i++){
	echo $estados[$i].":".$cantidades[$i]."<br>";
}
};?>

</div>

</body>

</html>