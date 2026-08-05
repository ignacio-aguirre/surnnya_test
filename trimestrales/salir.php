<?php 
include("funciones.php");
session_start();

if(isset($_SESSION["log_in"])) ejecute("update log_in_out set log_out=concat(curdate(),' ',curtime()) where idlog_in_out=".$_SESSION["log_in"]);
session_destroy();
if(isset($_SESSION["menu"])){Redirect("../surnnya");} else {Redirect(".");};
?>
