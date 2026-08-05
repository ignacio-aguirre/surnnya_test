<?php
if(isset($_SESSION["prestacion"])){$titulo=$_SESSION["prestacion"];$definicion_operativa="";}
else{
 $url=urlfinal($_SERVER["SCRIPT_NAME"]);
 $titulo=un_campo("select nombre_reporte from reportes where url_principal=".tsql($url));
 $definicion_operativa=un_campo("select definicion_operativa from reportes where url_principal=".tsql($url)); 
};
unset($_SESSION["prestacion"]);
if(!isset($_SESSION["glidusua"]) && !isset($_SESSION["login"])){Redirect("salir");};

function urlfinal($t){
   $t=substr($t,9,30);
   $l=strlen($t);
   $t=substr($t,0,$l-4);	
return $t;  
}

?>
<html><head><title><?php echo $titulo?></title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta name="google" content="notranslate" />
<link rel="icon" href="imagenes/BA2016.png" type="image/x-icon" />
<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css"></head><body>
<div class="container">
<div style='float:left'>
<h4><img src='imagenes/logoconsejo.png' height='70' width='70'>&nbsp;&nbsp;<?php echo $titulo.si($definicion_operativa!="","&nbsp;
<img src='imagenes/mas.png' height='20' width='20' onclick='alert(".'"'.$definicion_operativa.'"'.")'></img>","");?></h4>
</div>
<div style='float:right'>
<?php

$conmenu=1;

if(isset($_SESSION["login"])){
 $conmenu=0;
 unset($_SESSION["login"]);
};	


if(isset($_SESSION["sinmenu"])){
   $conmenu=0;
   unset($_SESSION['sinmenu']);
};

if($conmenu==0)  {
   echo "<a href='salir'><img width='20' height='20' src='imagenes/flecha.png'></a>";
}
else{
echo "Usuario:<strong>".$_SESSION["glusua"]."</strong>&nbsp;<img src='imagenes/llave.png' height='20' width='20' onclick=location.href='contrasena'>";
echo "<a href='".$_SESSION["menu"]."'><img width='20' height='20' src='imagenes/menu.png'>Men&uacute;</a>&nbsp;&nbsp;";
logueasistema();
echo '<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a><br>';
};

?>
<var id='stat_general'></var>
</div>
<script src="generales.js?v3.0"></script>
</div>

<div class="container" align="center">

