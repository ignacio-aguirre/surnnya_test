<?php
die("requiere revisar");
require("funciones.php"); 
session_start();
$_SESSION["prestacion"]="Agregar viajes futuros al proceso de hoy";
include("encabezado.php");
$fecha=un_campo("select date_add(".$_SESSIONnoexistemas["prox_laborable"].", interval 1 day)");
$fec=$fecha;
$fec2=$fec;
$tipo_movil="";
$mostrar=0;
if(isset($_GET["tipo_movil"])){
	$tipo_movil=nget("tipo_movil");
	$fec2=$_GET["fecha"];
	$fecha=str_replace("-","",$_GET["fecha"]);

	$mostrar=1;
}
?>
</div>
<div class="container">
<div class="row">

<form class="form-inline" method="get" >
	<div class="form-group has-warning col-md-4">
		<label class="label-form">Fecha</label>
		<input class="form-control" id="fecha" name="fecha" type="date" min='<?php echo $fec?>' value='<?php echo $fec2?>'>
	</div>
			<div class="form-group has-warning col-md-4">
			<label class="label-form">Tipo de m&oacute;vil</label>
			<select class="form-control" id="tipo_movil" name="tipo_movil"  required>
               <option value="">Completar</option>
				<?php
		 		$opc=registros("select valo,deno,info from tablas where tipo='MVTT' order by tipo");
		 			while($o=mysqli_fetch_assoc($opc)){
		   		echo "<option value='".$o["valo"]."'>".$o["deno"]." ".$o["info"]."</option>";}
         ?>
			</select>
			<script>seleccionar("tipo_movil","<?php echo $tipo_movil?>")</script>
		</div>
<div class="form-group has-warning col-md-4">	
	<button class="btn-success">Filtrar</button>
</div>

</form>

</div>
<div class="row">
	<div class="col-md-12" align="right">
<button class="btn-success" onclick="marcar(1)">Marcar todos</button>
<button class="btn-danger" onclick="marcar(0)">Desmarcar todos</button>
</div>
</div>
<div class="table-responsive pre-scrollable">
	<table class="table">
		<tr class="bg-success" style="font-size:.9em"><th>Efector</th><th>Hora</th><th>Partida</th><th>Destino</th><th>Incluir</th></tr>
		<?php if($mostrar==1){
			$via=registros("select movil_viajes.*, nombre from movil_viajes 
				left join dispositivos on dispositivo=dispositivos.id where tipo_movil=".$tipo_movil." and (f_proceso is null or f_proceso=".$_SESSION["fecha_proceso"].") and fecha=".$fecha." order by nombre, hora");
			while($v=mysqli_fetch_assoc($via)){
				echo "<tr style='font-size:.9em'><td>".$v["nombre"]."</td><td>".substr($v["hora"],0,5)."</td><td>".$v["partida"]."</td><td>".$v["destino_1"]."</td><td><input class='form-control chv' type='checkbox' ".si(ffec($v["f_proceso"])!=""," checked ","")." id='".$v["id"]."'></td></tr>";
			}
		}?>
	</table>
</div>
<button class="btn-success" onclick="guardar()">Guardar</button>
<script>
	function marcar(n){
		const coleccion=document.getElementsByClassName("form-control chv");
		for(i=0;i<coleccion.length;i++){
			obj=coleccion[i];
			
			if(n==1){
				obj.checked=true;
			} else{
				obj.checked=false;
			}
		}
	}
	function guardar(){
		const coleccion=document.getElementsByClassName("form-control chv");
		for(i=0;i<coleccion.length;i++){
			obj=coleccion[i];
			if(obj.checked==true){
				eje("validadores/mv_ffut?id="+obj.id);

			} else {
				eje("validadores/mv_ffut_q?id="+obj.id);
			}
		}
		navega("<?php echo $_SESSION['menu']?>");
	}
</script>
</div>