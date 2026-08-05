<?php 
include("funciones.php");
session_start();
tranca();
if(isset($_GET["tipo"])){
$_SESSION["tipo"]=$_GET["tipo"];
$_SESSION["id"]=$_GET["id"];
$_SESSION["referencia"]=$_GET["referencia"];
$_SESSION["retorno"]=$_GET["retorno"];
Redirect("archivo_subir");
};
$tipo=$_SESSION["tipo"];
$id=$_SESSION["id"];
$referencia=$_SESSION["referencia"];
$retorno=$_SESSION["retorno"];

$_SESSION["prestacion"]="Subir documento escaneado";
include("encabezado.php"); 
?>
</div>
<div class="container">
<form action="archivo_subida" method="post" enctype="multipart/form-data" onsubmit="return valida_arch()">
<?php echo "Archivo a vincular con ".$referencia."<br>";?>
<input name="archivo" id="archivo" type="file" size="35" /><br>
<input name="tipo" value="<?php echo $tipo;?>" hidden>
<input name="id" value="<?php echo $id;?>" hidden>
<input name="referencia" value="<?php echo $referencia;?>" hidden>
<input name="retorno" value="<?php echo $retorno;?>" hidden>
<input name='enviar' type='submit' value='Subir Archivo' />
</form>
</div>
<script src="bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script>
<script>
function valida_arch(){
nombre=document.getElementById("archivo").value;
if(nombre.lenght==0){alert("No se ha seleccionado archivo"); return false;};
return true;
}
</script>
</body>