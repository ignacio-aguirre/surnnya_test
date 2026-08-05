<?php
include('func.php');

session_start();

if($_SESSION["abm"]==0){
    $efector=nget('efector');
    $tipo_efector=un_campo("select tipo from efectores where idefectores=".$efector);
    $reg=registros("select idarticulos_rubros, descripcion from articulos_rubros order by descripcion");
    $s="";

    while($r=mysqli_fetch_assoc($reg)){

      $s=$s."<option value=".$r["idarticulos_rubros"].">".utf8_encode($r["descripcion"])."</option>";

    };

    echo $s;

}

else {

  echo opciones("articulos_rubros");

};

?>