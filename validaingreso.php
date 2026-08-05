<?php 
include("Funciones.php");
session_start();

if(!isset($_SESSION["gl_sesion"])){
	$usua=$_POST["mail"];
	$pass=strtoupper($_POST["password"]);
	if ($usua=="" || $pass=="") {Redirect("login_empty");};
	$usuario = un_registro("select usuarios.*, perfiles.denominacion as nperfil, sectores.denominacion as ndispo,
		sectores.hogar as hogar 
	from usuarios 
	left join perfiles on perfil=perfiles.id
	left join sectores on sector=sectores.id 
	where usuarios.baja is null and estado='ACTIVO' and email=".tsql($usua));
	if (is_null($usuario) ) {Redirect("login_failure");};
	if($usuario['intentos']>"5") {Redirect("login_blocked");};

	if(strtoupper($usuario["password"])!=strtoupper($pass)){
	ejecute("update usuarios set intentos=intentos+1 where email=".tsql($usua));Redirect("login_failure");
	};
}
else{
	$apynom=un_campo("select usuario from sesiones where idsesiones=".$_SESSION["gl_sesion"]);
	$usuario = un_registro("select usuarios.*, perfiles.denominacion as nperfil, sectores.denominacion as dispo, sectores.hogar as hogar 
		from usuarios left join perfiles on perfil=perfiles.id
		left join sectores on sector=sectores.id 
		where usuarios.baja is null and estado='ACTIVO' and 
concat(apellido,', ',nombre)=".tsql($apynom));
};

variables_iniciales($usuario);
//cambio de contraseña 
$ulca = intval(un_campo("select datediff(curdate(),pwcambio) from usuarios where id=".$usuario["id"]));

if($ulca>60){Redirect("contrasena");};
if($_SESSION['menu']=='mnu_dipp') {ejecute("update sujetos set sonidos=concat(lex_sonido(Apellidos),' ',lex_sonido(Nombres),' ',case when Apodos is null then '' else lex_sonido(Apodos) end) where sonidos is null");};
ejecute("update usuarios set intentos=0 where  email='".$usua."'");
$diasem=un_campo("select date_format(curdate(),'%w') from dual");
if($diasem>="1" && $diasem<="5"){
	$url=un_campo("select proc_url from procesos where dia_semana=0 and (ultimaejecucion is null or ultimaejecucion<curdate()) limit 1");
	if($url!=""){Redirect('porfavor?url='.$url);};
        $url=un_campo("select proc_url from procesos where dia_semana=".$diasem." and (ultimaejecucion is null or ultimaejecucion<curdate()) limit 1");
	if($url!=""){Redirect('porfavor?url='.$url);};
};

$autenticar=0;
if($usuario["f_autenticado"]==""){
	$autenticar=1;
}
else{
	$dias=intval(un_campo("select datediff(curdate(),f_autenticado) from usuarios where id=".$usuario["id"]));
	if($dias>20){ $autenticar=1;}
};
if($autenticar==1){
	Redirect("autenticar");
}
Redirect($_SESSION["menu"]."?id=1");

?>
