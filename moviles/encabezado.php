<html translate="no"><head><title>
        moviles 
   </title>
<meta name="google" content="notranslate" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootartap/bootstrap-4.0.0-dist/css/bootstrap.min.css"><link></head>

<!-- CSS de Bootstrap 4.0.0 -->
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous">

<!-- jQuery (necesario para JS de Bootstrap 4) -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>

<!-- Popper.js (necesario para tooltips, popovers, etc.) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>

<!-- JS de Bootstrap 4.0.0 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script src="js/generales.js?v='1.1.0.1'"></script>
<script src="js/moviles.js?v='2.1.0.1'"></script>

<body>
<div class="container">
<div style='float:left'>
<h4>M&oacute;viles - <?php echo $_SESSION["prestacion"]?></h4>

</div><div style='float:right'>
<?php 
if(!isset($_SESSION["ul"]) && !isset($_SESSION["usuario"])){
        Redirect("salir");
}
if(isset($_SESSION["nusuario"])){
       
echo "<strong>".$_SESSION["nusuario"];
$ndispo="";
if(isset($_SESSION["hogar"])){
        if($_SESSION["hogar"]>"0") {$ndispo=un_campo("select nombre from dispositivos where id=".$_SESSION["hogar"]);
        }
}        
if(isset($_SESSION["sector"])){
        if($_SESSION["sector"]>"0") {$ndispo=un_campo("select denominacion from sectores  where id=".$_SESSION["sector"]);
        };
};
if($ndispo!="") {echo "<br>".$ndispo;};

echo "</strong>&nbsp;<img src='imagenes/menu.png' height='20' width='20' onclick=location.href='".$_SESSION["menu"]."'>";
}else if(isset($_SESSION["login"])){
        unset($_SESSION["login"]);
}
else{
     //Redirect("salir");   
}

?>

<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a><br>

<var id='stat_general' class='text-danger'></var>

</div>
</div>

</div>

<br><br>