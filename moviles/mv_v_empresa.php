<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Emisión de documentos de viajes aprobados";
include("encabezado.php");
?>
</div>
<br><br>
<div class="container">
<?php
$oper=un_registro("select * from movil_procesos where proceso='Laborable' order by id desc limit 1");
$idproceso=$oper["id"];

$cnt=0;
$via=registros("select distinct empresa,deno 
        from movil_viajes 
        left join tablas on tipo='ETRA' and valo=movil_viajes.empresa
        where movil_viajes.bandeja =7 and estado='APR' and lote_envio=".$idproceso." order by empresa");

while($v=mysqli_fetch_assoc($via)){
    $cnt++;
    echo "<div class='row col-md-6'>";
    echo "<button class='btn-sm btn-success col-md-6' 
     onclick='gen_exe(".$v["empresa"].")'>Excel ".$v["deno"]." </button>&nbsp;&nbsp;</div><br><br><br>";
    
};
if($cnt==0){echo "Sin viajes en fecha ".ffec($oper["fecha_hoy"]);}
?>
</div>
<script>
    function gen_exe(empresa){
        naveganuevo('mv_generar_envio_do?empresa='+empresa);
    }
</script>
           