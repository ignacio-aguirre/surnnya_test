<div class="table-responsive">
       <table class="table-condensed table"> 
      <?php
        $regi=registros("select deno,count(*) as c from hogares_admision left join tablas on admi_cate=tablas.valo and tablas.tipo='ADCAT' where admi_susp is null and admi_alta is null  
and admi_fderiv is null group by  deno 
union all select 'TOTAL' as deno, count(*) from hogares_admision where admi_susp is null and admi_alta is null and admi_fderiv is null order by deno");
while($reg=mysqli_fetch_assoc($regi)){
 echo "<tr style='font-size:.7em'><td>";
 if($reg["deno"]=="") {echo "S/D";} else {echo $reg["deno"];};
 echo "</td><td>".$reg["c"]."</td></tr>";
};
?>
    </table>
</div>
<div class="table-responsive">
    <h4>Por Situaci&oacute;n Sociohabitacional</h4>	
    <table class="table-condensed table"> 
<?php
$regi=registros("select deno,count(*) as c from hogares_admision left join tablas on admi_proc=tablas.valo and tablas.tipo='HOSSH' where admi_susp is null and admi_alta is null  
and admi_fderiv is null group by  deno
union all select 'ZTOTAL' as deno, count(*) from hogares_admision where admi_susp is null and admi_alta is null  and admi_fderiv is null order by deno");
while($reg=mysqli_fetch_assoc($regi)){
 echo "<tr style='font-size:.7em'><td>";
 echo utf8_decode(strtoupper(si($reg["deno"]=="ZTOTAL","TOTAL",$reg["deno"])))."</td><td>";
 echo"</td><td>".$reg["c"]."</td></tr>";
};
?>
</table>
</div>
