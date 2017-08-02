requirejs(['knockout','models/Evento','models/Participante'],
	function(ko,Evento,Participante){

function ParticipanteEdit(data){
	var self=this;
	Participante.call(self,data);

	self.editing = ko.observable(false);

	self.edit = function() { 
		self.editing(true) 
	};

	self.nome.subscribe(function(){
		self.save({
			callback:function(){
				self.editing(false);
			}
		});
	});

};

function ParticipantesIndex(evento){
	var self = this;
	self.evento = ko.observable(evento);
	self.nomeParticipante =  ko.observable();

	self.criaParticipante = function(){
		var participante = new ParticipanteEdit({nome : self.nomeParticipante()});
		self.evento().addParticipante(participante,function(){
			self.nomeParticipante(null);
		});
	};

	self.delete = function(participanteToDelete){
		self.evento().removeParticipante(participanteToDelete);
	};

};

var idEvento = $('h3[data-id]').data('id');
Evento.load(idEvento,{
		participanteModel : ParticipanteEdit,
		include: '(Participantes)',
		callback : function(evento){
			ko.applyBindings(new ParticipantesIndex(evento),
			document.getElementById('ParticipantesModel'));
			}
		});
});