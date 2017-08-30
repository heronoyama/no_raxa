requirejs(['knockout','components/PathUtils','repository/ParticipantesRepository'],
	function(ko,PathUtils,ParticipanteRepository){

function ParticipantesIndex(idEvento){
	var self = this;
	self.idEvento = ko.observable(idEvento);

	var options = 

	self.repository = ko.observable(ParticipanteRepository.initialize({ idEvento : idEvento,editMode : true}));

	self.nomeParticipante =  ko.observable();

	self.criaParticipante = function(){
		self.repository().novoParticipante(self.nomeParticipante(), function(){
			 self.nomeParticipante(null);
		});
	};

	self.participantes = ko.computed(function(){
		return self.repository().participantes();
	});

	self.delete = function(participanteToDelete){
		self.repository().delete(participanteToDelete);
	};

};

var idEvento = PathUtils.extractEventoId();
ko.applyBindings(new ParticipantesIndex(idEvento),document.getElementById('ParticipantesModel'));
});