define(['knockout'],function(ko){
	function PathUtils(){
		var self = this;
		self.extractEventoId = function(){
			var exp = /eventos\/\d+/gm;
			var pathname = window.location.pathname;
			var hasEventos = pathname.match(exp);
			if(hasEventos.length == 0)
				return null;
			var numbers = hasEventos[0].match(/\d+/gm);
			return parseInt(numbers[0]);
		}

		self.convertToParameters = function(options){
			
		}
	}

	return new PathUtils();
});