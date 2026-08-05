<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])){ header ("Location: salir");};
$frase="";
if(isset($_GET["frase"]))  $frase=$_GET["frase"];

?>
<div class="container">
<form class="form-inline" method="get">
<div class="form-group has-warning">
<label class="label-form">Par&aacute;metro de B&uacute;squeda (todo o parte de los Apellidos / n&uacute;mero de legajo) </label>
<input class="form-control has-warning" name="frase" id="frase" size="30" maxlength="50" autofocus value="<?php echo $frase?>">
</div>
<input class="btn-warning btn-sm" type="submit" name="buscar" value="Buscar">
<input class="btn-success btn-sm" type="submit" name="excel"value="Excel">
</form>
<button class="btn-sm btn-info" onclick="navega('fv_familia_nueva')">Nueva Familia</button>
<script type="text/javascript">
function editar(id){
  navega("fv_familias_editar?id="+id+"&ret=2");	
}
function miembros(id){
  navega("fv_familias_miembros?id="+id);
}
function parti(id){
  navega("fv_familias_participacion?id="+id);
}
</script> 

<div class='table-responsive'>
<table class='table table-striped table-bordered'>

<tr>

<th>Familia</th><th>Legajo</th><th>Opciones</th></tr>
<?php
 if(isset($_GET["excel"])){Redirect("fv_fam_gen_excel");};
 if(isset($_GET["frase"])){
  $frase=$_GET["frase"];
  
  $sql="select idfv_familias,fv_familias.descripcion, fv_familias.legajomanual from fv_familias ";
 if(intval($frase)!=0) {$sql=$sql." where legajomanual=".$frase;}
 else{if($frase!=""){$sql=$sql." where descripcion like '%".$frase."%'";};};
 $sql=$sql." order by descripcion";
   $conn = registros($sql);
   $conta=0;
   $parti=0;
   while ($da = mysqli_fetch_assoc($conn)) {
   	$conta=$conta+1;
   	$parti=$da["parti"]+$parti;
      echo "<tr><td>".$da["descripcion"]."</td><td>".$da["legajomanual"].
           "</td><td><button class='btn btn-primary btn-sm' onclick='editar(".$da["idfv_familias"].")'>Editar</button>".
	   "&nbsp;<button class='btn btn-warning btn-sm' onclick='miembros(".$da["idfv_familias"].")'>Miembros</button>".
	   "&nbsp;<button class='btn btn-success btn-sm' onclick='parti(".$da["idfv_familias"].")'>Intervenciones</button>".
"</td></tr>";	
    };
    echo "<tr style='font-size:.70em'><td>".$conta." familias</td><td>".$parti."</td><td></td></tr>";   
};
?>

</table>

</div>

<?php if(isset($conta)){ echo 'Total ';echo $conta;echo ' registros ';};
?>
</body>
</html>