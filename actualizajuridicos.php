<?php
include("Funciones.php");
session_start();
$lega=$_POST['legajo'];
$jumo=nulea($_POST['jumo']);
$junu=nulea($_POST['junu']);
$dezo=nulea($_POST['dezo']);
$deeq=$_POST['deeq'];
$tmed=nulea($_POST['tmed']);
$zpro=nulea($_POST['zpro']);
ejecute("update sujetos_juridicos set fecha=curdate() where legajo=".$lega);
ejecute("update sujetos_juridicos set juzgado_modalidad=".$jumo.", juzgado_numero=".$junu." where legajo=".$lega);
ejecute("update sujetos_juridicos set juzgado_expediente='".$_POST['expe']."', juzgado_caratula='".$_POST['cara']."' where legajo=".$lega);
ejecute("update sujetos set defensoria_zonal=".$dezo.", tipo_medida=".$tmed.", zonal_provincial=".$zpro." where legajo=".$lega);
ejecute("update sujetos set equipo=".tsql($deeq)." where legajo=".$lega);
Redirect("suje_cons_juridicos?legajo=".$lega);
?>