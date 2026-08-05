<footer class="text-left" style="font-size: .7em;background-color : #F2F3FI;">
<?php
if(!isset($_SESSION["version"])){
    $modulo="SURNNYA";
    $entorno=un_campo("select entorno from parametros");
    $ver=un_registro("select * from surnnya.versiones where modulo=".tsql($modulo)." and entorno=".tsql($entorno));
    
    $_SESSION["version"]=$entorno.":".$ver["ver_1"].".".$ver["ver_2"].".".$ver["ver_3"];
};
echo ipactual();
?>        
<p>Versi&oacute;n <?php echo $_SESSION["version"] ?></p>
<div id='fechahora'>
</div>

</footer>
<script type='text/javascript'>

var ocurre=100;

var myVar=setInterval(function(){myTimer()},1000);



</script>