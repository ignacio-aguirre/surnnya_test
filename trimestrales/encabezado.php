<html lang="ES"><head><title><?php echo $_SESSION["prestacion"]?></title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">'
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
<link rel="icon" href="imagenes/favicon.png" type="image/x-icon" />

</head><body>       


<div class="container">

<div style='float:left'>

<h4>Trimestrales - <?php echo $_SESSION["prestacion"]." ".$_SESSION["trimestre"]." ".$_SESSION["anio"]?></h4>

</div>

<div style='float:right'>

Usuario:<strong><?php 
if(!isset($_SESSION)) Redirect(".");
if(!isset($_SESSION["menu"])){
 echo un_campo("select concat(apellidos,', ',nombres) from usuarios_hogares where id=".$_SESSION["usuario"]);}
else{
 
 echo un_campo("select concat(apellido,', ',nombre) from usuarios where id=".$_SESSION["glidusua"]);
};

?></strong>&nbsp;<img src='imagenes/llave.png' height='20' width='20' onclick=location.href="cambiar_password">

<?php if($_SESSION["prestacion"]!="Men&uacute;") echo "<a href='menu'><img width='20' height='20' src='imagenes/menu.png'>Men&uacute;</a>&nbsp;&nbsp;"?>

<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a><br>

<var id='stat_general' class='text-danger'></var><var class="text-warning" id="enfocador"></var>

</div>

<script src="js/nuevos.js?v="+Math.random()></script>

<script>var ocurre=800;iniciar()</script>
</div>

<div class="container" align="center">
<?php if(un_campo("select acceso_restringido from parametros where idparametros=1")=="1"){die("El acceso al sistema est&aacute; moment&aacute;neamente restringido. Prob&aacute; m&aacute;s tarde.");};?>


