<?php 
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])|!isset($_POST['ilegajo'])) Redirect("salir");
$lega=$_POST["ilegajo"];
$apel=$_POST["iapellidos"];
$nomb=$_POST["inombres"];
$apod=$_POST["iapodos"];
$sexo=$_POST["isexo"];
$gene=$_POST["i_gene"];
$tdoc=$_POST["itdoc"];
$dni=$_POST["idni"];
$para=$_POST["ilocparada"];
$lupa=$_POST["ilugparada"];
$proc=$_POST["ilocprocedencia"];
$edad=$_POST["iedad"];
$mese=$_POST["imese"];
$actu=$_POST["iactedad"];
$fnac=$_POST["ifnacimiento"];
$naci=$_POST["nacionalidad"];
$lloc=$_POST["ilocal"];
$abie=$_POST["iabie"];
$cerr=$_POST["icerr"]; 
$rib=$_POST["rib"];
if(substr($rib,0,4)=="RIB-"){
$rani=substr($rib,4,4);
$rib=substr($rib,9);
$rnum=substr($rib,0,strpos($rib,"-"));
$rrep=substr($rib,strpos($rib,"-")+1);
 
}
else{
$rani=substr($rib,0,4);
$rib=substr($rib,5);
$rnum=substr($rib,0,strpos($rib,"-"));
$rrep=substr($rib,strpos($rib,"-")+1);
};
$cuil=tpost("cuil");
$suj= un_registro("select * from sujetos where legajo=".$lega);
ejecute("update sujetos set apellidos='".$apel."',nombres='".$nomb."',apodos='".$apod."' where legajo=".$lega);
ejecute("update sujetos set sonidos=concat(lex_sonido(Apellidos),' ',lex_sonido(Nombres),' ',case when Apodos is null then '' else lex_sonido(Apodos) end) where legajo=".$lega);
ejecute("update sujetos set sexo='".$sexo."', genero=".nulea($gene).", tipodni=".nulea($tdoc).",sujetosdni=".nulea($dni)." where legajo=".$lega);
ejecute("update sujetos set f_nacimiento=".fsql($fnac).", sujetosedad=".nulea($edad).",sujetosmeses=".nulea($mese).", nacionalidad=".$naci." where legajo=".$lega);
ejecute("update sujetos set sujetosactedad=".fsql($actu).", locparada=".nulea($para).",lugparada='".$lupa."',locvivienda=".nulea($proc).", cuil=".$cuil." where legajo=".$lega);
ejecute("update sujetos set rib_anio=".nulea($rani).", rib_numero=".tsql($rnum).", rib_reparticion=".tsql($rrep)." where legajo=".$lega);

if (intval($lloc)>0) 

 {

  $di = un_registro("select legajolocal from legajos where legajounico=".$lega." and dispolegajo=".$_SESSION['gldispo']);

  if($di['legajolocal']=="") ejecute("insert into legajos(legajounico,dispolegajo,legajolocal) values(".$lega.", ".$_SESSION['gldispo'].", ".$lloc.")");

  ejecute("update legajos set legajolocal=".$lloc.", abierto=".$abie.", cerrado=".$cerr." where legajounico=".$lega." and dispolegajo=".$_SESSION['gldispo']);

 }

else  ejecute("delete from legajos where  legajounico=".$lega." and dispolegajo=".$_SESSION['gldispo']);

Redirect("suje_cons_duros?legajo=".$lega); 

?>



