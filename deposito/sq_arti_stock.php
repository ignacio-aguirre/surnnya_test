<?php

include('func.php');

session_start();

$id=nget('articulo');
echo un_campo('select cantidad from existencias where articulo='. nulea($id));

?>