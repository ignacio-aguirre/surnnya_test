<?php
require("funciones.php"); 
session_start();
$_SESSION["prestacion"]="Domicilios";
include("encabezado.php");
$dom=registros("select domicilios.*, (select count(*) from movil_domicilios where iddomicilios=domicilios.id) as cnt from domicilios order by case when localidad='CABA' then '1' else partido end, localidad, calle, altura");
?>
</div>
<div class="container">
 <div class="row">
    <h4 class="col-md-6">Domicilios registrados</h4>
    
 </div>
<hr>
	<div class="table-responsive pre-scrollable">
	<table class="table">
	<thead>
	 <tr class="bg-success" style="font-size:.8em"><th>Id</th><th>Direcci&oacute;n</th><th>Localidad</th><th>Partido</th><th>Barrio</th><th>Comuna</th><th>Cnt</th><th>Referencia</th><th>Opciones</th></tr>
        </thead>
        <tbody>
           <?php
	while($d=mysqli_fetch_assoc($dom)){
	        echo "<tr style='font-size:.8em' ".si($d["normalizada"]=="1",""," class='danger'")."><td>".$d["id"]."</td><td>".$d["direccion"]."</td><td>".$d["localidad"]."</td><td>".$d["partido"]."</td><td>".$d["barrio"]."</td><td>".$d["comuna"]."</td><td>".$d["cnt"]."</td><td><input id='".$d["id"]."' value='".
						$d["ref_general"]."' onblur='referencia(this.id)'></td><td><button class='btn-sm btn-primary'>ok</button>
          </td></tr>";
	}
	?>
        </tbody>
        </table>
        </div>
      <br><br>
				
</div>
<script>

function referencia(idobjeto){
			refe=document.getElementById(idobjeto).value;
			id=idobjeto;
			if(refe!=""){
				resp=eje("validadores/domicilios_referencia?id="+id+"&refe="+refe);
				document.getElementById(idobjeto).value=resp;
			}
		}
</script>
</body>