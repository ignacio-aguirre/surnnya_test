<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Reportes del Sistema";
include("encabezado.php");
if ($_SESSION['gl_usuarios']!="1") redirect('error_noautorizado');

?>
<div class="container">
	<button class="btn-warning" onclick="edita(0)">Nuevo Reporte</button>&nbsp;&nbsp;&nbsp;<button class="btn-success" onclick="navega('reportes_excel')">Lista Excel</button> 
	<div class="table-responsive">
		<table class="table table-condensed">
			<tr class="bg-primary" style="font-size:.8em"><th>Id</th><th>Nombre en Reporte</th><th>Nombre en Men&uacute;</th><th>Url Principal</th><th>Excel</th><th>Acciones</th></tr>
			<?php $reg=registros("select * from reportes order by id");
				while($r=mysqli_fetch_assoc($reg)){
 					echo "<tr style='font-size:.8em'><td>".
                                        $r["id"]."</td><td>".$r["nombre_reporte"]."</td><td>".$r["nombre_menu"]."</td><td>".$r["url_principal"].
                                        "</td><td>".si($r["excel"]=="1","S&iacute;","No")."</td><td><img src='imagenes/Play.jpg' onclick='play(".'"'.$r["url_principal"].'","'.$r["script"].'")'."'  height='20' width='20'>Ver</img>
                                       &nbsp;&nbsp;<button class='btn-small btn-primary' onclick='edita(".$r["id"].")'>Editar</button></td></tr>";
				};
			?>
		</table>
	</div>
		
</div>
<script>
function edita(id){
navega("un_reporte?id="+id);
};
function play(url,script){
	if(url!=""){ naveganuevo(url);}
	else{navega("ejecutar?sent="+script);};
}
</script>
</body>
</html>