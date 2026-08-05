<?php
require("Funciones.php");
session_start();
$tipo=$_GET["tipo"];
if($tipo=="GRUPO"){
  $id=$_GET["id"];
  $apellidos=gtsql("apellidos");
  ejecute("update grupos set apellidos=".$apellidos." where idgrupos=".$id);
  echo $id;
};

if($tipo=="MEDIDA_LEGA"){
  $arch=$_GET["arch"];
  $lega=$_GET["lega"];
  $fecha=$_GET["fecha"];
  $dias=$_GET["dias"];
  $noinno=$_GET["noinno"];
  ejecute("insert into archivos_vinculos(archivo,tipo,identificador) values(".$arch.",'S',".$lega.")");
  $paramed=ejecute("insert into sujetos_medidas(legajo,fecha,dias,no_innovar,archivo) values(".$lega.",".$fecha.",".$dias.",".$noinno.",".$arch.")");
  $jumo=$_GET["jumo"];
  $junu=$_GET["junu"];
  $dezo=$_GET["dezo"];
  $juex=$_GET["juex"];
  $juca=$_GET["juca"];
  if($jumo!="") ejecute("update sujetos_juridicos set juzgado_modalidad=".$jumo." where legajo=".$lega);
  if($junu!="") ejecute("update sujetos_juridicos set juzgado_numero=".$junu." where legajo=".$lega);
  if($juex!="") ejecute("update sujetos_juridicos set juzgado_expediente=".tsql($juex)." where legajo=".$lega);
  if($juca!="") ejecute("update sujetos_juridicos set juzgado_caratula=".tsql($juca)." where legajo=".$lega);
  if($dezo!="") ejecute("update sujetos set defensoria_zonal=".$dezo." where legajo=".$lega);
  echo "ok";
};

if($tipo=="PERSONA_CONS"){

 $id=$_GET["id"];

 $cant=un_campo("select count(*) as cosa from personas where idpersonas=".$id." or nrodoc=".$id);

 if($cant=="1") {echo un_campo("select concat(idpersonas,'&',apellidos,', ',nombres) from personas where idpersonas=".$id." or nrodoc=".$id);} else {echo "0";};
 exit();
};


if($tipo=="CONS_ARCHIVOS"){
$lega=$_GET["legajo"];
$orde=$_GET["orden"];
$sql="select deno,restringido,as_descripcion, as_fechadoc,concat(denominacion,'-',as_usuario) as efector, as_fecha as fecha,
  as_dispositivo, as_usuario, idarchivos_subidos as id, fileserver  
  from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo 
  left join tablas on tablas.tipo='TA' and tablas.valo=as_tipo 
  where archivos_vinculos.tipo='S' and identificador=".$lega." and as_baja is null ";
  if($orde=="1") {$sql=$sql."  order by deno,as_fecha desc";} else {$sql=$sql."  order by as_fecha desc, deno";} ; 
  $conn = registros($sql);
   while ($da = mysqli_fetch_assoc($conn)) {
    if($da["restringido"]==0||$_SESSION["menu"]=="menusys") {
     echo "<tr style='font-size:.80em;'><td>".$da['deno']."</td><td>".$da['as_descripcion']."</td><td>".ffec($da['as_fechadoc'])."</td><td>".$da['efector']."</td><td>".ffec($da['fecha'])."</td><td>";
     echo "<a href='descarga_nuevo?id=".$da['id']."'>Descargar</a>";
     if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) echo "<a href='archdesvincular?id=".$da['id']."&tipo=S&identificador=".$lega."'> Desvincular</a>";
     echo "</td></tr>";
    };
   };
};

if($tipo=="CONS_ARCHIVOS_ONG"){
$id=$_GET["ong"];
$orde=$_GET["orden"];
$sql="select deno,restringido,as_descripcion, as_fechadoc,concat(denominacion,'-',as_usuario) as efector, as_fecha as fecha,
  as_dispositivo, as_usuario, idarchivos_subidos as id, fileserver  
  from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo 
  left join tablas on tablas.tipo='TA' and tablas.valo=as_tipo 
  where archivos_vinculos.tipo='O' and identificador=".$id." and as_baja is null ";
  if($orde=="1") {$sql=$sql."  order by deno,as_fecha desc";} else {$sql=$sql."  order by as_fecha desc, deno";} ; 
  $conn = registros($sql);
   while ($da = mysqli_fetch_assoc($conn)) {
    if($da["restringido"]==0||$_SESSION["menu"]=="menusys") {
     echo "<tr style='font-size:.80em;'><td>".$da['deno']."</td><td>".$da['as_descripcion']."</td><td>".ffec($da['as_fechadoc'])."</td><td>".$da['efector']."</td><td>".ffec($da['fecha'])."</td><td>";
     echo "<a href='descarga_nuevo?id=".$da['id']."'>Descargar</a>";
     if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) echo "<a href='archdesvincular?id=".$da['id']."&tipo=O&identificador=".$id."'> Desvincular</a>";
     echo "</td></tr>";
    };
   };
};

if($tipo=="CONS_ARCHIVOS_DISPOSITIVO"){
$id=$_GET["dispositivo"];
$orde=$_GET["orden"];
$sql="select deno,restringido,as_descripcion, as_fechadoc,concat(denominacion,'-',as_usuario) as efector, as_fecha as fecha,
  as_dispositivo, as_usuario, idarchivos_subidos as id, fileserver  
  from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo 
  left join tablas on tablas.tipo='TA' and tablas.valo=as_tipo 
  where archivos_vinculos.tipo='H' and identificador=".$id." and as_baja is null ";
  if($orde=="1") {$sql=$sql."  order by deno,as_fecha desc";} else {$sql=$sql."  order by as_fecha desc, deno";} ; 
  $conn = registros($sql);
   while ($da = mysqli_fetch_assoc($conn)) {
    if($da["restringido"]==0||true) {
     echo "<tr style='font-size:.80em;'><td>".$da['deno']."</td><td>".$da['as_descripcion']."</td><td>".ffec($da['as_fechadoc'])."</td><td>".$da['efector']."</td><td>".ffec($da['fecha'])."</td><td>";
     echo "<a href='descarga_nuevo?id=".$da['id']."'>Descargar</a>";
     if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) echo "<a href='archdesvincular?id=".$da['id']."&tipo=H&identificador=".$id."'> Desvincular</a>";
     echo "</td></tr>";
    };
   };
};

if($tipo=="FAHOGARES"){
 $id=$_GET["id"];
 $fami=registros("select idaf_familias,denominacion from af_familias where hogar=".$id." and estado1=1 and tipo_prestacion in (1,3,4,6,8) order by denominacion");
 while($f=mysqli_fetch_assoc($fami)){
  echo "<option value='".$f["idaf_familias"]."'>".$f["denominacion"]."</option>";
 };
};

if($tipo=="FAMILIA_CONS"){
 $id=$_GET["id"];
 $cant=un_campo("select count(*) as cosa from af_familias where idaf_familias=".$id);
 if($cant=="1") {echo un_campo("select idaf_familias from af_familias where idaf_familias=".$id);} else echo "0";
};

if($tipo=="FAMILIA_UNREGISTRO"){
 $id=$_GET["id"];
 echo "<?xml version='1.0' encoding='ISO-8859-1' ?>";
 $c=un_re("select * from af_familias where idaf_familias=".$id);
 $conta=count($c);
 echo "<familia>";
 for ($i = 0; $i < $conta; $i++) {echo "<c".$i.">";
                                 echo $c[$i];
                                 echo " </c".$i.">";}
 echo "</familia>";
};

if($tipo=="FAMILIA"){
 $id=$_GET["id"];
 $denominacion=gtsql("denominacion");
 $registro=nulea($_GET["registro"]);
 $disposicion=gtsql("disposicion");
 $hogar=nulea($_GET["hogar"]);
 ejecute("update af_familias set disposicion=".$disposicion.",hogar=".$hogar.",registro_unico=".$registro." where idaf_familias=".$id);
 echo $id;
};



if($tipo=="PEDIDONUEVO"){

 $legajo=$_GET["legajo"];

 ejecute("insert into hogares_admision(admi_legajo,admi_obse,admi_usuario) values(".$legajo.",".tsql(ipactual()).",".tsql($_SESSION["glusua"]).")");

 $id=un_campo("select idhogares_admision from hogares_admision where admi_usuario=".tsql($_SESSION["glusua"])." and admi_legajo=".$legajo." and admi_fped is null and admi_obse=".tsql(ipactual())." limit 1");

 ejecute("update hogares_admision set admi_obse=null where idhogares_admision=".$id);

 echo $id;

};



if($tipo=="PEDIDOF"){

 $id=$_GET["id"];

 $campo=$_GET["campo"];

 $valor=gfsql("valor");

 $sql="update hogares_admision set ".$campo."=".$valor." where idhogares_admision=".$id;

 ejecute($sql);

};



if($tipo=="PEDIDON"){

 $id=$_GET["id"];

 $campo=$_GET["campo"];

 $valor=nulea($_GET["valor"]);

 $sql="update hogares_admision set ".$campo."=".$valor." where idhogares_admision=".$id;

 ejecute($sql);

};



if($tipo=="PEDIDOT"){

 $id=$_GET["id"];

 $campo=$_GET["campo"];

 $valor=gtsql("valor");

 $sql="update hogares_admision set ".$campo."=".$valor." where idhogares_admision=".$id;

  if($valor!="") ejecute($sql);

};






if($tipo=="S_CNS_ARCHIVOS"){

  $sql="select deno,restringido,as_descripcion, concat(denominacion,'-',as_usuario) as efector, as_fecha as fecha, as_path,

  as_dispositivo, as_usuario, idarchivos_subidos as id 

  from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo 

  left join tablas on tablas.tipo='TA' and tablas.valo=as_tipo 

  where archivos_vinculos.tipo='S' and identificador=".$lega." and as_baja is null 

  order by as_fecha desc,as_tipo";

  $conn = registros($sql);

   while ($da = mysqli_fetch_assoc($conn)) {

    if($da["restringido"]==0||$_SESSION["menu"]=="menusys") {

     echo "<tr style='font-size:.80em;'><td>".$da['deno']."</td><td>".$da['as_descripcion']."</td><td>".$da['efector']."</td><td>".ffec($da['fecha'])."</td><td><a href='descarga?link=".sacamas($da['as_path'])."&nombre=".sacamas_limpia(sacapath($da['as_path']))."'>Descargar</a>";

     if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) echo "<a href='archdesvincular?id=".$da['id']."&tipo=S&identificador=".$lega."'> Desvincular</a>";

     echo "</td></tr>";

    };

   };



};




if($tipo=="SUPERIORES"){
 $menu=nget("menu");
 $reg=registros("select * from menues_superiores where menu=".$menu." order by orden");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<option value='".$r["orden"]."'>".$r["titulo"]."</option>";
 };
};

if($tipo=="CONVIVIENTES"){
 $id=nget("id");
 $reg=registros("select af_familias_grupo.*,personas.*,edadcalc(fecha_nacimiento,edad,0,fecha_actualizacion,curdate()) as edc from af_familias_grupo left join personas on persona=idpersonas where familia=".$id." order by idaf_familias_grupo");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["persona"]."</td><td>".$r["apellidos"].", ".$r["nombres"]."</td><td>".dvin($r["vinculo"])."</td><td>".$r["edc"].
 "</td><td>".$r["ocupacion"]."</td><td>".si($r["conviviente"]=="1","SI","NO")."</td></tr>";
 };
};

if($tipo=="hogares_ong"){
 $ong=nget("ong");
 $t="";
 $reg=registros("select dispositivos.id, nombre from dispositivos where baja is null and ong=".$ong." order by nombre");
 while($r=mysqli_fetch_assoc($reg)){
  $t=$t."<option value='".$r["id"]."'>".$r["nombre"]."</option>";
 };
 echo $t;
};
if($tipo=="roles_funcion"){
 $hogar=nget("hogar");
 $usuario=nget("usuario");
 echo un_campo("select funcion from usuarios_hogares_roles where hogar=".$hogar." and usuario=".$usuario);
};

function gtsql($t){

return tget($t);

}



function gfsql($t){

return fget($t);

}



function gnsql($t){

return nget($t);

}
function dvin($t){
if($t=="1") return "Referente";
if($t=="2") return "Conyuge";

if($t=="3") return "Hijo/a";

if($t=="5") return "Progenitor";
return "";
}
?>

