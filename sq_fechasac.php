<?php
include("Funciones.php"); 
session_start();
$desde=fget("desde");
if(substr($desde,-2)=="01"){
	$seguir=true;
	for($i=1;$i<=7;$i++){
 		if($seguir){
  			$dia=(string)$i;
  			$hasta=substr($desde,0,7).$dia;
  			$seguir=(un_campo("select date_format(".$hasta.",'%w') from dual")!="0");
 		};
	};
	echo substr($hasta,-2)."/".substr($hasta,4,2)."/".substr($hasta,0,4);
}
else {
 	if(un_campo("select date_format(".$desde.",'%w') from dual")!="1"){$hasta="";}
 	else{
   		$seguir=true;
   		$hasta=$desde;
   		for($i=1;$i<=6;$i++){
   			if($seguir){ 
    				$fecha=fsql(ffec(un_campo("select date_add(".$hasta.", INTERVAL 1 DAY) from dual")));
    				if(substr($fecha,0,6)==substr($desde,0,6)){$hasta=$fecha;}
				else {$seguir=false;};
			};
   		};
        	$hasta= substr($hasta,-2)."/".substr($hasta,4,2)."/".substr($hasta,0,4);
  	};
        echo $hasta;
};
?>