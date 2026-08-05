<?php
include("funciones.php"); 
session_start();
$tp=nget("tp");
$di=nget("di");
$pb=tget("pba");
$pba=si($pb=="'SI'","1","0");
$d2=nget("d2");
if($tp=="2"){
	$opc=registros("select * from movil_renglones where tipo=2
	 and ".$di." between distancia_minima and distancia_maxima and ((".$d2."=1 and id=2) or (".$d2."=0))  order by id");
}
else {
	if($pba=="1") {
		$opc=registros("select * from movil_renglones where tipo=1 and es_pba=1 order by id");
	} else{
		$opc=registros("select * from movil_renglones where tipo=1 and 
			es_pba=0 and ". $di." between distancia_minima and distancia_maxima order by id");
	};

};	
while($o=mysqli_fetch_assoc($opc)){
		
          echo "<option value='".$o["id"]."'>".$o["nombre_info"]."</option>";
         
      };
exit();
?>