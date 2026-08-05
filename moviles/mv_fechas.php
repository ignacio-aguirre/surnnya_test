<?php
session_start();
include("funciones.php"); 

$_SESSION["prestacion"]="Revisi&oacute;n de fechas futuras";
include("encabezado.php");
$fechas=registros("select * from fechas where fecha > curdate()   order by fecha asc limit 60");
?>
</div>
<div class="container">

        <h4 >Fechas pr&oacute;ximas</h4>
	<div class="table-responsive pre-scrollable">
	<table class="table">
	<thead>
	 <tr class="bg-success" ><th>Fecha</th><th>D/semana</th><th>Laborable</th><th>Próximo Laborable</th><th>Acciones</th></tr>
        </thead>
        <tbody>
           <?php
	while($f=mysqli_fetch_assoc($fechas)){
         echo "<tr class='".si($f["laborable"]=="1","text-success","text-danger")."'><td>".ffec($f["fecha"])."</td><td>".$f["ds"]."</td><td>".si($f["laborable"]=="1","Si","No")."</td><td>";
         $pl=un_campo("select min(fecha) from fechas where laborable=1 and fecha>".fsql(ffec($f["fecha"])));
         echo "<div class='text-success'>".ffec($pl)."</div></td><td>";
         if($f["laborable"]=="1"){
      	echo "<button class='btn-sm btn-danger' onclick='cnolab(".$f["id"].")'>Cambiar a No laborable</button>&nbsp;";
  	      }
  	      
  	      else {
	  	   
	  	   if($f["ds"]!="sáb" && $f["ds"]!="dom"){ echo "<button class='btn-sm btn-success' onclick='camlab(".$f["id"].")'>Cambiar a Laborable</button>&nbsp;";
	      }
	    }

	   
	   echo "</td></tr>";};
	  
	  
	     
	
	?>
        </tbody>
        </table>
        </div>
					
</div>
<script>
function cnolab(id){
 navega("mv_fecha_cambiar?id="+id+"&l=0");
}
function camlab(id){
 navega("mv_fecha_cambiar?id="+id+"&l=1");
}
</script>
</body>