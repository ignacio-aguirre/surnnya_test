function normalizara(campo,controla){
  var v = new View(campo,"listado");
  var ic = new usig.InputController(campo, function(key, newValue) {
  if (newValue!=''&&controla==1) {
    try {
    	var opts = n.normalizar(newValue, 10);
	v.clean();
        v.show(opts, 10);
	} catch (error) {
	    		try {
				opts = n.buscarDireccion(newValue);
				if (opts!==false)
					v.show([opts.match], 2);
				else
					v.showError(error);
				}catch(error){v.showError(error);}
			}
	} else {
			v.clean();
		}
	});
 }

