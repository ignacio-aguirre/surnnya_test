<?php
include("funciones.php");
session_start();
tranca();
$id=nget("id");
ejecute("update usuarios set clausula=0 where idusuarios=".$id);
Redirect("unusuario?id=".$id);
?>