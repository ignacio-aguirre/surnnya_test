<?php

function tablas_generales()

{

// Carga de tablas en opciones

//  Localidades

                $sql="select idlocalidades, tipo, descripcion, grupo from localidades order by descripcion";
                $conn = registros($sql);
                $loc_caba ="<option value=''>---Completar</option>";
                $loc_gene ="<option value=''>---Completar</option>";
                while ($dt = mysqli_fetch_assoc($conn)) {
                 if($dt['tipo']=="C"||$dt['tipo']=="S") $loc_caba=$loc_caba."<option value='".$dt['idlocalidades']."'>".$dt['descripcion']." ".$dt['grupo']."</option>";
                 $loc_gene=$loc_gene."<option value='".$dt['idlocalidades']."'>".$dt['descripcion']." ".$dt['grupo']."</option>";} ; 
                $_SESSION['loc_caba']=$loc_caba;
                $_SESSION['loc_gene']=$loc_gene;

//  Sectores

                $conn = registros("select id, denominacion from sectores where baja is null order by denominacion");

                 $Opc_dispo_todos="<option value=''>--Completar</option>";

                

		while ($da = mysqli_fetch_assoc($conn)) {

		$Opc_dispo_todos=$Opc_dispo_todos."<option value='".$da['id']."'>".$da['denominacion']."</option>";
		

     };           
                

		$_SESSION['Opc_dispo_todos']=$Opc_dispo_todos;
                $_SESSION['Opc_dispo']=$Opc_dispo_todos;



//dia_hoy 

                $sql="select curdate() as hoy";

                $conn = registros($sql);

		$dt = mysqli_fetch_assoc($conn);

                $DiaHoy=$dt['hoy'];

                $_SESSION['DiaHoy']=ffec($DiaHoy);



// Generales de Supervision



$a=tablas_hogares();

return "OK";

}



function opc_tabla($tipo){
$reg=registros("select * from tablas where baja is null and tipo=".tsql($tipo)." order by info,deno");

$o="";

while($r=mysqli_fetch_assoc($reg)){

 $o=$o."<option value='".$r["valo"]."'>".$r["deno"]." ".$r["info"]."</option>";

};

return $o;

}

function opc_tablav($tipo){
$reg=registros("select * from tablas where baja is null and tipo=".tsql($tipo)." order by valo");

$o="";

while($r=mysqli_fetch_assoc($reg)){

 $o=$o."<option value='".$r["valo"]."'>".$r["deno"]."</option>";

};

return $o;

}



function tablas_hogares()

{

// Lectura de Tablas específicas de hogares



//Hogares

if (!isset($_SESSION['Opc_Hoga'])) {

$conn = registros("select dispositivos.id as id, nombre from dispositivos where baja is null and tipo_dispositivo in(1,2,11,12) and nomina_hogares=1 order by nombre");

$Opc_Hoga ="<option value=''>---Completar</option>";

while ($dt = mysqli_fetch_assoc($conn)) {

    $Opc_Hoga=$Opc_Hoga."<option value='".$dt['id']."'>".$dt['nombre']."</option>";

} ; 

$_SESSION['Opc_Hoga']=$Opc_Hoga;

} ; 

// Hogares de acogimiento

if (!isset($_SESSION['Opc_Hoga_AF'])) {

$conn = registros("select dispositivos.id as id, nombre from dispositivos where baja is null and tipo_dispositivo=1 order by nombre");

$Opc_Hoga ="<option value=''>---Completar</option>";

while ($dt = mysqli_fetch_assoc($conn)) {

    $Opc_Hoga=$Opc_Hoga."<option value='".$dt['id']."'>".$dt['nombre']."</option>";

} ; 

$_SESSION['Opc_Hoga_AF']=$Opc_Hoga;

} ; 

 

// categorias

if (!isset($_SESSION['Opc_Hoga_Cate'])) {

$conn=registros("select valo, deno from tablas where tipo='ADCAT' order by deno");

$Opc_Hoga_Cate ="<option value=''>---Completar</option>";

while ($dt = mysqli_fetch_assoc($conn)) {

  $Opc_Hoga_Cate=$Opc_Hoga_Cate."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

} ; 

$_SESSION['Opc_Hoga_Cate']=$Opc_Hoga_Cate;

};

// procedencias

if (!isset($_SESSION['Opc_Hoga_Proc'])) {

$conn=registros("select valo, deno,deta from tablas where tipo='HOSSH' and baja is null order by deno");

$Opc_Hoga_Proc ="<option value=''>---Completar</option>";

while ($dt = mysqli_fetch_assoc($conn)) {

  $Opc_Hoga_Proc=$Opc_Hoga_Proc."<option value='".$dt['valo']."'>".$dt['deno'];

  if($dt['deta']==1) $Opc_Hoga_Proc=$Opc_Hoga_Proc." *DET*";

  $Opc_Hoga_Proc=$Opc_Hoga_Proc."</option>";

} ; 

$_SESSION['Opc_Hoga_Proc']=$Opc_Hoga_Proc;

};

// mot.ingreso

if (!isset($_SESSION['Opc_Hoga_Ming'])) {

$conn = registros("select valo, deno from tablas where tipo='HOMOI' order by deno");
$Opc_Hoga_Ming ="<option value=''>---Completar</option>";
$Opc_Hoga_Ming_Cons ="<option value=''>---Todos</option>";
while ($dt = mysqli_fetch_assoc($conn)) {
  $Opc_Hoga_Ming=$Opc_Hoga_Ming."<option value='".$dt['valo']."'>".$dt['deno']."</option>";
  $Opc_Hoga_Ming_Cons=$Opc_Hoga_Ming_Cons."<option value='".$dt['valo']."'>".$dt['deno']."</option>";
} ; 
$_SESSION['Opc_Hoga_Ming']=$Opc_Hoga_Ming;
$_SESSION['Opc_Hoga_Ming_Cons']=$Opc_Hoga_Ming_Cons;
};

// mot.egreso

if (!isset($_SESSION['Opc_Hoga_Megr'])) {

$conn = registros("select valo, deno from tablas where tipo='HOMOE' and baja is null order by deno");

$Opc_Hoga_Megr ="<option value=''>---Completar</option>";

$Opc_Hoga_Megr_Cons ="<option value=''>---Todos</option>";

while ($dt = mysqli_fetch_assoc($conn)) {

  $Opc_Hoga_Megr=$Opc_Hoga_Megr."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

  $Opc_Hoga_Megr_Cons=$Opc_Hoga_Megr_Cons."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

 };

$_SESSION['Opc_Hoga_Megr']=$Opc_Hoga_Megr;

$_SESSION['Opc_Hoga_Megr_Cons']=$Opc_Hoga_Megr_Cons;



}; 



//Hospitales para at

if (!isset($_SESSION['Opc_Hosp_At'])) {

        $Opc_Hosp_At="";

	$conn=registros("select * from salud_establecimientos where left(descripcion,4) in ('HOSP','OTRO') order by descripcion");

        while ($dt = mysqli_fetch_assoc($conn)) {

        	$Opc_Hosp_At=$Opc_Hosp_At."<option value='".$dt['idsalud_establecimientos']."'>".$dt['descripcion']."</option>";

        };

       $_SESSION['Opc_Hosp_At']=$Opc_Hosp_At;

};



return true;

}


//tablas

function tabla($tipo){

if($tipo=="loc_gene") {

       $reg=registros("select idLocalidades, tipo_localidad, deno_localidad, grupo_localidad from localidades order by deno_localidad");

       while ($dt = mysqli_fetch_assoc($reg)) {

	$opciones=$opciones."<option value='".$dt['idLocalidades']."'>".$dt['deno_localidad']." ".$dt['grupo_localidad']."</option>"; 

       };         

};



if($tipo=="loc_caba") {

 $reg=registros("select idLocalidades, tipo_localidad, deno_localidad, grupo_localidad from localidades where tipo_localidad in('C','S') order by deno_localidad");

       while ($dt = mysqli_fetch_assoc($reg)) {

	$opciones=$opciones."<option value='".$dt['idLocalidades']."'>".$dt['deno_localidad']." ".$dt['grupo_localidad']."</option>"; 

       };

};





if($tipo=="Opc_Hoga_Proc") {

  	$reg=registros("select id, Denominacion,detalle from hogares_proc where baja is null order by Denominacion");

	while ($dt = mysqli_fetch_assoc($reg)) {

  	$opciones=$opciones."<option value='".$dt['id']."'>".$dt['Denominacion'];

  	if($dt['detalle']==1) $opciones=$opciones." *DET*";

        } ; 

};



return $opciones;

};



function tbla($tipo){

$opciones="<option value='-1'>S/D</option>";





if($tipo=="barrios"){

	$reg = registros("select * from barrios_caba  order by barrio");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['idbarrios_caba']."'>".$dt['barrio']." ".$dt['comuna']."</option>";

	};

};



if($tipo=="caba"){

	$reg = registros("select * from tablas where tipo='CABA' and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};





if($tipo=="categorias_admision"){

	$reg = registros("select * from tablas where tipo='ADCAT'  and baja is null  order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};



if($tipo=="derivantes_admision"){

	$reg = registros("select * from tablas where tipo='ADDER'  and baja is null  order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno'];

               if($dt['deta']==1) $opciones=$opciones. " *DET*";

               $opciones=$opciones."</option>";

	};

};





if($tipo=="comuna"){

	$reg = registros("select * from tablas where tipo='CM'  and baja is null  order by deno");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

	};

};



if($tipo=="contacto"){

	$reg = registros("select * from tablas where tipo='CONTACTO'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};





if($tipo=="estadocivil"){

	$reg = registros("select * from tablas where tipo='EC'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};



if($tipo=="e_egreso"){

	$reg = registros("select * from tablas where tipo='EE'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

	};

};

if($tipo=="funcion"){

	$reg = registros("select * from tablas where tipo='FN'  and baja is null order by deno");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

	};

};







if($tipo=="m_ingr_super"){

	$reg = registros("select * from tablas where tipo='MISUP'  and baja is null order by deno");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

	};

};



if($tipo=="v_contextuales"){

	$reg = registros("select * from tablas where tipo='CTEX'  and baja is null order by deno");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

	};

};



if($tipo=="nacionalidad"){

	$reg = registros("select * from tablas where tipo='NA'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};



if($tipo=="nivel"){

	$reg = registros("select * from tablas where tipo='NE'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};

if($tipo=="hogares_ong"){
	$reg = registros("select * from hogares_ong where baja is null order by nombre");
	while ($dt = mysqli_fetch_assoc($reg)) {
  		$opciones=$opciones."<option value='".$dt['id']."'>".$dt['nombre']."</option>";
	};
};

if($tipo=="sino"){

  $opciones=$opciones."<option value='1'>Si</option><option value='0'>No</option>";

};



if($tipo=="sseducativa"){

	$reg = registros("select * from tablas where tipo='SE'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};



if($tipo=="sshabitacional"){

	$reg = registros("select * from tablas where tipo='SH'  and baja is null  order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};



if($tipo=="tipoarchivo"){

	$reg = registros("select * from tablas where tipo='TA'  and baja is null order by deno");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

	};

};





if($tipo=="tipodoc"){

	$reg = registros("select * from tablas where tipo='TD'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};



if($tipo=="vinculo"){

	$reg = registros("select * from tablas where tipo='VI'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};



if($tipo=="vinculo_mas"){

	$reg = registros("select * from tablas where tipo='VM'  and baja is null order by valo");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['valo'].".".$dt['deno']."</option>";

	};

};



if ($tipo=='TU'||$tipo=="AC"||$tipo=="ES"||$tipo=="TINTH"||$tipo=="TI"||$tipo=="TM"||$tipo=="TJ"||$tipo=="ALU"||$tipo=="APR"||$tipo=="AES"||$tipo=="HAT"||$tipo=="ZP"||$tipo=="HOPPE"||$tipo=="APA"||$tipo=="APL"||$tipo=="ETEE"){

	$reg = registros("select * from tablas where tipo='".$tipo."'  and baja is null order by deno");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['valo']."'>".$dt['deno']."</option>";

	};

};



if($tipo=="UMO"){

	$reg = registros("select * from usuarios where baja is null and perfil=53 order by apellido, nombre");

	while ($dt = mysqli_fetch_assoc($reg)) {

  		$opciones=$opciones."<option value='".$dt['id']."'>".$dt['apellido'].", ".$dt['nombre']."</option>";

	};

};



return $opciones;

};

function select_tabla($nombre,$tipo,$obligatorio,$vacio){
 $t="<select class='form-control' name='".$nombre."' id='".$nombre."'".si($obligatorio," required ","").">";
 if($vacio) {$t=$t."<option value=''></option>";};
 $rt=registros("select * from tablas where tipo='".$tipo."' and baja is null order by info,valo");
 while($s=mysqli_fetch_assoc($rt)){
   $t=$t."<option value='".$s["valo"]."'>".si($s["info"]!="",$s["info"],$s["deno"])."</option>";
 };
 $t=$t."</select>";
 return $t;
}



?>