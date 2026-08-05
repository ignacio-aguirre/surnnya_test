<?php
include("Funciones.php");
session_start();
registre();
$opci="";
if ($_SESSION["gl_todos_dispo"]==1) $opci="<option value='0'>--Todos</option>";
$opci=$opci.$_SESSION['Opc_dispo'];
$conn=registros("select valo, concat(info,'-',deno) as denom from tablas where tipo='TINT' order by denom");
$opci3="<option value=''>---Todos</option>";
while ($da = mysqli_fetch_assoc($conn)) $opci3=$opci3."<option value='".$da['valo']."'>".$da['denom']."</option>";
$_SESSION['prestacion']="Acciones";
include("encabezado.php");
?>
</div>
<div class="container">

<form method="get"  enctype="multipart/form-data">
<div class="table-responsive">
<table class="table">
<tr>
<td>Fecha Desde/Hasta</td> 
<td><input size="10"  class="form-control" type="text" name="i_fdes" id="fd" value="<?php if(isset($_GET["i_fdes"])) echo $_GET["i_fdes"];?>" onblur="valida_fecha('fd')"/></td>
<td><input size="10"  class="form-control" type="text" name="i_ftop" value="<?php if(isset($_GET["i_ftop"])) echo $_GET["i_ftop"];?>" id="ft" onblur="valida_fecha('ft')"/></td>
<td>Efector</td><td><select  class="form-control" name='i_dispo' id='ids'><?PHP echo $opci;?></select></td></tr>
<tr><td colspan="3">Tipo de Acci&oacute;n<select  class="form-control" id='tipo' name='i_tipo'><?php echo $opci3;?></select></td>
<td><input type="checkbox" name="mias" id="mias" checked value="Mias">S&oacute;lo m&iacute;as</td>
</tr>
<tr>
<td colspan="3">Apellido<input size="30" maxlength="45" class="form-control" type="text" name="i_apel"  id="apel" value="<?php if(isset($_GET["i_apel"])) echo $_GET["i_apel"];?>" onblur="valida_0('apel')"/></td>
<td colspan="3"> Nombre<input size="30" maxlength="45"  class="form-control" type="text" name="i_nomb"  id="nomb" value="<?php if(isset($_GET["i_nomb"])) echo $_GET["i_nomb"];?>" onblur="valida_0('nomb')"/></td></tr>
<tr><td><input name="submit" class="btn-primary" type="submit" value="Consultar" /></td></tr>
</tr>

</table>
</div>
<?php if(isset($_GET["i_dispo"])) echo "<script type='text/javascript'>seleccionar('ids','".$_GET["i_dispo"]."');seleccionar('tipo','".$_GET["i_tipo"]."')</script> ";?>
<script type="text/javascript">enfoca("fd");document.getElementById("mias").checked=false;</script>
</form>
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr class="bg-primary" style="font-size:.8em">
<th align="left">Acci&oacute;n</th><th>Efector</th><th>Fecha</th><th align="left">Legajo</th><th>Apellido y Nombre</th><th>Tipo Intervenc.</th><th>Operadores</th>
</tr>
</thead>
<?php
if (isset($_GET["i_fdes"]) and isset($_GET["i_ftop"]) )
{$fdes= $_GET["i_fdes"];
$ftop= $_GET["i_ftop"];
$disp=$_GET["i_dispo"];
$apel=$_GET["i_apel"];
$nomb=$_GET["i_nomb"];
$tipo=$_GET["i_tipo"];
$mias="";
if(isset($_GET["mias"])) $mias=$_GET["mias"];
if ($fdes!=""&& $ftop!="") {
        $fde=fsql($fdes); 
        $fto=fsql($ftop); 
	$sql="select intervenciones.*,  (select count(*) from intervenciones_archivos where intervencion=idintervenciones) as arch, datediff(curdate(),inter_fecha) as dife, sujetos.*,sectores.denominacion as ddispo, 
  salud_establecimientos.descripcion as inst ,
  tablas.deno as tipo from intervenciones  inner join sectores on sectores.id=inter_dispo ";

	$sql=$sql." left join sujetos on inter_legajo=sujetos.legajo ";

	
	$sql=$sql." left join salud_establecimientos on inter_hosp=idsalud_establecimientos ";
	$sql=$sql." left join tablas on tablas.tipo='TINT' and inter_tipo=tablas.valo ";
	$sql=$sql." where inter_fecha between ".$fde." and ".$fto;
	if ($disp>"0") $sql=$sql." and inter_dispo= ".$disp;
        if($tipo!="") $sql=$sql." and inter_tipo=".$tipo;
        if ($apel!="") {
		 $sapel=un_campo("select lex_sonido('".$apel."') as son");
		 $sql=$sql." and lex_sonido(apellidos) like '%".$sapel."%'";};
	if ($nomb<>"")  {
		 $snomb=un_campo("select lex_sonido('".$nomb."') as son");
		 $sql=$sql." and lex_sonido(nombres) like '%".$snomb."%'";};
	if($mias!="") $sql=$sql." and inter_usuario='".$_SESSION["glusua"]."'";	 
	$sql=$sql." order by  inter_fecha, inter_dispo, inter_oper ";
	$conn = registros($sql);
	$cant = mysqli_num_rows($conn);

        if ($cant> 0) 

	   while ($da = mysqli_fetch_assoc($conn)) {   

              $lega=$da['inter_legajo'];
              $lega="<a href='suje_cons_duros?legajo=".$lega."'>".$lega."</a>";
       	      $apel=$da["Apellidos"];
              $nomb= $da["Nombres"];
              if($da['inter_tipo']<>29||$_SESSION["gldispo"]==11||$_SESSION["gldispo"]==19||$_SESSION["gldispo"]==12||($_SESSION["gldispo"]==2 &&$_SESSION['glidperfil']==7 )){
	      
              echo "<tr style='font-size:.8em'><td>";

              if($da['dife']<100 && $da['arch']==0 && ($_SESSION['gl_acciones']==1||$_SESSION['glusua']==$da['inter_usuario']) && $da['dispo']=$_SESSION['gldispo']) echo "<a href='interborra?iid=".$da["idintervenciones"]."&retorno=intervenciones"."'><img height='15' width='15' src='imagenes/eliminar.png'></a>";

              if(($_SESSION['gl_acciones']==1||$_SESSION['glusua']==$da['inter_usuario']) && $da['dispo']=$_SESSION['gldispo']) echo "<a href='interedita?iid=".$da["idintervenciones"]."'><img height='15' width='15' src='imagenes/editar.png'></a>";

              echo " </a>";

              if($da["arch"]>0) echo "(".$da["arch"].")";

              echo "</a>";

              echo "</td>";

	      echo "<td>".$da["ddispo"]."</td>";	

	      echo "<td>".substr($da["inter_fecha"],8,2)."/".substr($da["inter_fecha"],5,2)."/".substr($da["inter_fecha"],0,4)."</td>";	
	      echo "<td>".$lega."</td>";
	      echo "<td>".$apel." , ".$nomb."</td>";
	      echo "<td>".$da["tipo"]."</td>";
	

	      echo "<td>".$da["inter_oper"]."</td></tr>";

      	      echo "<tr><td colspan='11'>".$da["inter_obse"]."(<var style='font-size:8pt;'>".$da["inter_usuario"]." ".$da["fechahora"]."</var>)</td></tr>";

	      };

	   };



};

};

?>

</table>

</div>
</div>

</body>

</html>