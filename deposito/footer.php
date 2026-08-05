<footer class="text-left" style="font-size: .7em;">
<?php
if(!isset($_SESSION["version"])){
    $ver=un_registro("select * from surnnya.versiones where modulo='DEPOSITO'");
    $_SESSION["version"]=$ver["entorno"].":".$ver["ver_1"].".".$ver["ver_2"].".".$ver["ver_3"];
};?>        
<p>Versi&oacute;n <?php echo $_SESSION["version"] ?></p>
</footer>