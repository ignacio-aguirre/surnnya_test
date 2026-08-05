<?php
include("Funciones.php"); 
session_start();
include("encabezado.php");
registre();
$opci=str_replace("Completar","Todas",$_SESSION["Opc_Hoga_Cate"]);
$hasta=$_SESSION['DiaHoy'];
$desde="01".substr($_SESSION['DiaHoy'],2);
$hogar="";
$edesde="0";
$ehasta="30";
$factu="";
if (isset($_GET["idesde"]))
{
$desde=$_GET["idesde"];
$hasta=$_GET["ihasta"];
$hogar=$_GET["ihogar"];
$edesde=$_GET["e_desde"];
$ehasta=$_GET["e_hasta"];
$factu=$_GET["factu"];
};
?>

<div class="container">
<form class="form-inline"method="get" enctype="multipart/form-data">
<fieldset>

<label>Desde</label><input type="text" size="10" maxlength="10" name="idesde" id="i_desde" onblur="valida_fecha('i_desde')" value="<?php echo $desde;?>">

<label>Hasta</label><input type="text" size="10" maxlength="10" name="ihasta" id="i_hasta" onblur="valida_fecha('i_hasta')" value="<?php echo $hasta;?>">

<label>Hogar</label><select name="ihogar" id="i_hogar"><?php echo $_SESSION['Opc_Hoga'];?></select> 

<label>Cat.Fact.</label><input onblur="valida_0(this.id)" id="factu" name="factu" size="3" maxlength="3" value="<?php echo $factu;?>"><br>

Rango Etario desde <input type="text" size="2" maxlenght="2" name="e_desde" onblur="valida_entero(this.id)" value="<?php echo $edesde;?>">

hasta <input type="text" size="2" maxlenght="2" name="e_hasta" onblur="valida_entero(this.id)" value="<?php echo $ehasta;?>">

<input class="btn btn-primary" name="submit" type="submit" value="Consultar" />

</fieldset>

<script type="text/javascript">enfoca("i_desde");seleccionar("i_hogar","<?php echo $hogar;?>");</script> 

</form>
<div class="table-responsive">
<table class="table">
<tr>
<th style='font-size:8pt;'>Hogar</th><th style='font-size:8pt;'>Apellido y Nombre</th><th style='font-size:8pt;'>Sexo</th><th style='font-size:8pt;'>Edad (hoy)</th><th style='font-size:8pt;'>Doc.Identidad</th><th style='font-size:8pt;'>Alta</th><th style='font-size:8pt;'>Baja</th><th style='font-size:8pt;'>RIB</th><th style='font-size:8pt;'>Dias</th><th style='font-size:8pt;'>Cat.Fac.</th>
<?php

if (isset($_GET["idesde"]))

{

$desde=$_GET["idesde"];

$hasta=$_GET["ihasta"];

$hogar=$_GET["ihogar"];
	$sql="select idhogares_admision,sujetos.legajo as lega, Apellidos, Nombres, sexo, edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad_calc,tstd.deno as tdde, SujetosDNI, admi_alta as alta,admi_baja as baja, nombre as hogar, diasentre(admi_alta,admi_baja,".fsql($desde).",".fsql($hasta).") as dias, admi_fact, rib_anio, rib_numero, rib_reparticion from hogares_admision ";
	$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";
	$sql=$sql." left join dispositivos on admi_hogar=dispositivos.id ";
	$sql=$sql." left join tablas as tstd on tstd.tipo='TD' and tstd.valo=TipoDNI ";
	$sql=$sql." where ".si($factu!="","admi_fact='".$factu."' and ",""). " admi_alta is not null and admi_alta<=".fsql($hasta)." and (admi_baja>=".fsql($desde)." or admi_baja is null) and edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) between ".$edesde." and ".$ehasta." ";

        if($hogar!="") {$sql=$sql." and admi_hogar=".$hogar;};

        $sql=$sql." union select 0 as idhogares_admision, 'ZZZ' as lega, 'ZZZ' as Apellidos, 'TOTAL' as Nombres, '' as sexo, '' as edad_calc,null as TipoDNI,null as SujetosDNI,null as alta, null as baja, nombre as hogar,  sum(diasentre(admi_alta,admi_baja,".fsql($desde).",".fsql($hasta).")) as dias, '' as admi_fact , null as rib_anio, null as rib_numero, null as rib_reparticion from hogares_admision " ;

	$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";
	$sql=$sql." left join dispositivos on admi_hogar=dispositivos.id ";

	$sql=$sql." where ".si($factu!="","admi_fact='".$factu."' and ",""). " admi_alta is not null and admi_alta<=".fsql($hasta)." and (admi_baja>=".fsql($desde)." or admi_baja is null) and edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) between ".$edesde." and ".$ehasta." ";

        if($hogar!="") {$sql=$sql." and admi_hogar=".$hogar;};

	$sql=$sql." group by hogar ";

	$sql=$sql." order by  hogar,Apellidos, Nombres,alta";

       

	$conn = registros($sql);

	$conta=0;

	while ($da = mysqli_fetch_assoc($conn)) {

         $conta=$conta+1;

         if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};

         $apel=$da["Apellidos"]." , ".$da["Nombres"];

         $documento=$da["tdde"]." ".$da["SujetosDNI"];

         if(gettype($da["SujetosDNI"])=="NULL") $documento="Leg. ".$da["lega"];



         echo "<td style='font-size:8pt;'>";

         if($da["Apellidos"]=="ZZZ") {$apel="Total"; echo "<strong>";};

         echo $da["hogar"]."</td>";

         echo "<td style='font-size:8pt;'>".$apel."</td>";

         echo "<td style='font-size:8pt;'>".$da["sexo"]."</td>";

         echo "<td style='font-size:8pt;'>".$da["edad_calc"]."</td>";

         echo "<td style='font-size:8pt;'>";

         if($da["Apellidos"]!="ZZZ") echo $documento;

         echo "</td>";

         echo "<td style='font-size:8pt;'>".ffec($da["alta"])."</td>";	

         echo "<td style='font-size:8pt;'>".ffec($da["baja"])."</td>";	

         echo "<td style='font-size:8pt;'>";

         if($da["Apellidos"]!="ZZZ") echo rib($da["rib_anio"],$da["rib_numero"],$da["rib_reparticion"]);

         echo "</td>";

         echo "<td style='font-size:8pt;'>";

         if($da["Apellidos"]=="ZZZ") echo "<strong>";

	 echo $da["dias"]."</td><td style='font-size:8pt;'>".$da["admi_fact"].si($da["idhogares_admision"]==0,"","<a href='admiedita?iid=".$da["idhogares_admision"]."'>Cambiar</a>")."</td>";

         echo "</tr>";};	



};



?>

</table>
</div>
<?php if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};?>

</div>

</body>

</html>