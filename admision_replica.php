<?php

include("Funciones.php");

session_start();

$id=nget("id");

$lega=nget("legajo");

inserte("insert into hogares_admision (admi_legajo,admi_fped,admi_cate,admi_proc,admi_proc_cual,admi_deriv,admi_deriv_sector,admi_deriv_cual,admi_moti,admi_admi,admi_usuario) select ".$lega.", admi_fped,

admi_cate,admi_proc,admi_proc_cual,admi_deriv,admi_deriv_sector,admi_deriv_cual,admi_moti,admi_admi,admi_usuario from hogares_admision where idhogares_admision=".$id);

?>