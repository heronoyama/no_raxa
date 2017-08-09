requirejs(['knockout','components/PathUtils','models/Participante'],
	function(ko,PathUtils,Participante){

function ParticipanteEdit(data){
	var self=this;
	Participante.model.call(self,data);

	self.editing = ko.observable(false);
	self.edit = function() { 
		self.editing(true) 
	};

	self.nome.subscribe(function(){
		self.save(function(){
				self.editing(false);
		});
	});

};

function ParticipantesIndex(idEvento){
	var self = this;
	self.idEvento = ko.observable(idEvento);
	self.participantes = ko.observableArray([]);

	self.nomeParticipante =  ko.observable();

	self.criaParticipante = function(){
		var participante = new ParticipanteEdit({
			nome : self.nomeParticipante(), 
			idEvento:self.idEvento()
		});

		participante.save(
				function(participante){
                    var participantes = self.participantes();
                    ko.utils.arrayPushAll(participantes,[participante]);
                    self.participantes(participantes);
					self.participantes.valueHasMutated();
					self.nomeParticipante(null);
                }
            );
	};

	self.delete = function(participanteToDelete){
		 participanteToDelete.delete(function(participante){
                self.participantes.remove(participante);
                self.participantes.valueHasMutated();
            });
	};

	function load(){
		var options = {
			idEvento : self.idEvento(),
			model : ParticipanteEdit,
			callback : function(participantes){
				self.participantes(participantes);
			}
		};

		Participante.factory.loadAll(options);
	}
	load();
};

var idEvento = PathUtils.extractEventoId();
ko.applyBindings(new ParticipantesIndex(idEvento),document.getElementById('ParticipantesModel'));
});