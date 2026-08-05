<?php
include("../Funciones.php"); 
session_start();
$id=nget("id");
$f_hasta=fget("f_hasta");
$tipobaja=nget("tipobaja");
if($tipobaja=="1"){
 $resp=un_campo("select id from af_apoyos where curdate()>=".$f_hasta." and f_desde<=".$f_hasta." and id=".$id);
 if($resp==$id){echo "OK";} else{echo "Error fecha de baja";};
}
else{echo "OK";};
?>