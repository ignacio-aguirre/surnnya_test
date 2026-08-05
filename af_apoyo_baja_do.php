<?php
require("Funciones.php");
session_start();
$id=nget("id");
$f_hasta=fget("f_hasta");
$tipobaja=nget("tipobaja");
$alojamiento=un_campo("select alojamiento from af_apoyos where id=".$id);
if($tipobaja=="1"){
  ejecute("update af_apoyos set f_hasta=".$f_hasta." where id=".$id);
} else{ejecute("delete from af_apoyos where id=".$id);};
Redirect("af_apoyos?id=".$alojamiento);
?>