<script>
var ocurre=1000;
var myVar=setInterval(function(){myTimer()},1000);

function myTimer(){
ocurre=ocurre-1;
if(ocurre<1) navega("salir");
};

</script>
