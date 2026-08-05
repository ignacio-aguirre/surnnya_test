// Definicion del namespace
if (typeof (usig) == "undefined")
	usig = {};

usig.InputController = function(idField, callback, opts) {
	var changeCallback = callback;
	var field = document.getElementById(idField);
	var myself = this;
	
	if (!field) {
		return 0;
	} else {
		field.onkeyup = function(ev) { return myself.onKeyUp(ev); };	
	}
	
	this.onKeyUp = function(ev) {
		var key = (window.event) ? window.event.keyCode : ev.keyCode;
		if (typeof(changeCallback) == "function") {
			changeCallback(key, field.value);
		}
	}
}