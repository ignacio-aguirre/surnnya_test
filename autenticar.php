<?php
session_start();
include("Funciones.php");
function aleat(){
	$d1=(string) rand(0,9);
	$d2=(string) rand(0,9);
	$d3=(string) rand(0,9);
	$d4=(string) rand(0,9);
	$d5=(string) rand(0,9);
	return $d1.$d2.$d3.$d4.$d5;
}

$codigo=aleat();
$idusua=$_SESSION["glidusua"];

ejecute("update usuarios set c_autenticacion=".tsql($codigo)." where id=".$idusua);
error_reporting(E_STRICT);
require 'vendor/autoload.php';
$mail = new PHPMailer\PHPMailer\PHPMailer(true);
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPTimeOut = 190; 
$mail->SMTPDebug = 0; 
$mail->SMTPSecure      = "tls";                  // enable SMTP authentication
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtppro.zoho.com"; // sets the SMTP server
$mail->Port          = 587;                    // set the SMTP port for the GMAIL server
$mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
$mail->Password      = "718Q21_Mi";        // SMTP account password 
$mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
$mail->Subject       = "SURNNYA: Codigo para autenticar usuario";
$reg=un_registro("select  * from usuarios where id=".$_SESSION["glidusua"]);
if($reg["id"]>"0"){
  $mail->MsgHTML("<html>Estimado/a <strong>".$reg['nombre']." ".$reg['apellido']."</strong><br>C&oacute;digo autenticaci&oacute;n: <strong>".$reg["c_autenticacion"]."</strong><br><br><br>Mensaje generado autom&aacute;ticamente por SURNNYA</html>");
  $mail->AddAddress($reg['email'], $reg['nombre']." ".$reg['apellido']);
  if(!$mail->Send()){die("err:".$mail->ErrorInfo);};
  $mail->ClearAddresses();
  $_SESSION["prestacion"]="Autenticaci&oacute;n";
$_SESSION["login"]="1";
include("encabezado-test.php");
unset($_SESSION['glidusua']);
 }
 else{
 	die("error id");
 };  
 ?>
  	<br><br>
    <div class="container">
    	<p class="text-primary">Se ha enviado un c&oacute;digo por mail</p>
    	<form class="form-inline" method="post" action="autenticar_do">
    		<div class="form-group has-warning">
    			<label class="label-form">Ingresa los 5 d&iacute;gitos</label>
    			<input class="form-control" name="codigo" id="codigo" size="5">
    		</div>
    		<input hidden name="id" value="<?php echo $idusua?>">
    		<button class="btn-success">Enviar</button>
    	</form>
    	<var id="ocu"></var>
    </div>	
    <script>
    	var ocurre=100;
			var myVar=setInterval(function(){miTimer()},1000);

    function miTimer(){
			document.getElementById("ocu").innerHTML=ocurre;
			ocurre=ocurre-1;
			if(ocurre<1) navega("salir");

		};
	</script>