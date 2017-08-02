requirejs(['knockout','models/Evento'],function(ko,Evento){
	function EventosViewModel(){
		var self = this;
		
		self.evento =  ko.observable(new Evento.model());
		self.editing = ko.observable(false);

		self.edit = function() { this.editing(true); };

		self.save = function() {
            self.evento().update(function(){
            	alert("Evento atualizado com sucesso!");
                self.editing(false);
            });
        };

	};

	ko.applyBindings(new EventosViewModel(),document.getElementById("EventoModel"));

});