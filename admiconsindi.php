<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$opci=str_replace("Completar","Todas",$_SESSION["Opc_Hoga_Cate"]);
$cate="";
if(isset($_GET["icate"])){$cate=$_GET["icate"];};
$fini="01".substr($_SESSION['DiaHoy'],2);
$ffin=$_SESSION['DiaHoy'];
if(isset($_GET["fini"])){
 $fini=$_GET["fini"];
 $ffin=$_GET["ffin"];
};
?>
<div class="container">
<form class="form-inline">
 <div class='form-group has-warning'>
  <label>Desde/Hasta</label><input type="text" name="fini" size="10" maxlength="10" id="fini" onblur="valida_fecha('fini')" value="<?php echo $fini;?>"> 
  <input type="text" name="ffin" size="10" maxlength="10" id="ffin" onblur="valida_fecha('ffin')" value="<?php echo $ffin;?>"> 
 </div>
 <div class='form-group has-warning'>
  <label class='label-form' for='categoria'>Categor&iacute;as</label>
  <select class='form-control' name="icate" id="categoria"><?php echo $opci;?></select>&nbsp;&nbsp;&nbsp;
 </div>
<input name="submit" type="submit" value="Consultar" />
</form>
<script type="text/javascript">enfoca("categoria");seleccionar('categoria','<?php echo $cate;?>');</script> 
<strong>Pedidos a Asignar</strong>
<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr>
<th>Mes-A&ntilde;o</th><th>Pedidos</th><th>% Suspendidos</th><th>% Asignados</th><th>ds Pe-As</th><th>Ingresos</th><th> % </th><th>ds Pe-In</th>
<?php
if (isset($_GET["icate"]))
{
 $cate=$_GET["icate"];
 echo "<script type='text/javascript'>seleccionar('i_cate','".$cate."');</script>";
    $sql="select year(admi_fped) as anio,month(admi_fped) as mes, count(*) as cantidad,
    sum(case when admi_susp is null then 0 else 1 end) as susp,
    sum(case when admi_fderiv is null then 0 else 1 end) as asig,
    sum(case when admi_fderiv is null then 0 else datediff(admi_fderiv,admi_fped) end) as sdias,
    sum(case when admi_alta is null then 0 else datediff(admi_alta,admi_fped) end) as adias,
    sum(case when admi_alta is null then 0 else 1 end) as alta 
 
    from hogares_admision where admi_fped between ".fsql($fini)." and ".fsql($ffin).
    si($cate=="",""," and admi_cate=".$cate).
    " group by year(admi_fped), month(admi_fped) order by year(admi_fped) desc, month(admi_fped) desc";
    $conn = registros($sql);

    $conta=0;

    while ($r = mysqli_fetch_assoc($conn)) {

      echo "<tr><td>".$r["anio"]."/".$r["mes"]."</td><td>".$r["cantidad"]."</td><td>".si($r["cantidad"]==0,"",round(100*$r["susp"]/$r["cantidad"]))."</td><td>";
      echo si($r["cantidad"]==0,"",round(100*$r["asig"]/$r["cantidad"]))."</td><td>";
      if($r["asig"]>0) echo round(($r["sdias"]/$r["asig"]))."</td><td>";
      echo $r["alta"]."</td><td>";
      echo si($r["cantidad"]==0,"",round(100*$r["alta"]/$r["cantidad"]))."</td><td>";
      if($r["alta"]>0) echo round(($r["adias"]/$r["alta"]))."</td></tr>";

     };


  };

	

		




?>

</table>

</div>


</div>



</body>

</html>