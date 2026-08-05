<?php
if(isset($_SESSION["titulo"])){$titulo=$_SESSION["titulo"];};
unset($_SESSION["titulo"]);

function urlfinal($t){
   $t=substr($t,9,30);
   $l=strlen($t);
   $t=substr($t,0,$l-4);	
return $t;  
}

?>
<html translate="no"><head><title><?php echo $titulo?></title>
<meta name="google" content="notranslate" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<link rel="stylesheet" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css"></head><body>

<div class="container">
<div class="row">
<div class="col-md-8"></div>
<div class="col-md-4">

<?php


if($_SESSION["login"]=="1"){

 $_SESSION["login"]="0";

}	

else{

echo "Usuario:<strong>".$_SESSION["glusua"]."</strong>&nbsp;<img src='imagenes/llave.png' height='20' width='20' onclick=location.href='contrasena'>&nbsp;";

echo "<a href='menu'><img width='20' height='20' src='imagenes/menu.png'>Men&uacute;</a>&nbsp;&nbsp;";

};

?>

<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>
</div>
</div>
<script src="js/generales.js?v='1.1.0.1'"></script>

</div>

