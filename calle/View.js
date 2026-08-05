View = (function($) {
	return function (idField,otro) {

                
                inserto='<div id="suggestions" style="height:100px;max-height:200px;overflow:auto;">Sugerencias:</div>  ';tata="#suggestions";
		var $field = $('#'+idField);
		if (!$field) {
			return 0;
		} else {
			$field.parent('form').after(inserto);	
		}
		
		this.show = function(opts, limit) {
	        if (opts instanceof Array) {
	    		if (opts.length > 0) {
	                var ul = '<p>Sugerencias:</p><ul>';
	    			if (opts.length == limit)
	    				opts.push({ toString: function() { return 'etc';} });
	    			for(var op=0;op<opts.length;op++) {  
                                     callecita=decodeURIComponent(escape(opts[op].toString() ));
 
                                     ul += '<li><a href="javascript:pega('+"'"+callecita+"',"+"'"+idField+"'"+');">'+callecita +'</a></li>';
	    			}
	    			ul+='</ul>';
	    			$(tata).html(ul);
	    		} else {
	    			$(tata).html('No se hallaron sugerencias.');
	    		}
	        }
		}
		
		this.showError = function(error) {
	        $(tata).html(error.toString());		
		}
		
		this.clean = function() {
			$(tata).html('');
		}
	};
})(jQuery);