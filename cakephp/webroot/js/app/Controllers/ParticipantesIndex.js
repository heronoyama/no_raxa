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


// function EventoModel(idEvento){
// 	var self = this;
// 	self.participantes = ko.observableArray([]);
// 	self.id = ko.observable(idEvento);
// 	self.nomeParticipante =  ko.observable();

// 	self.criaParticipante = function(){
// 		var data = {nome: self.nomeParticipante()};
// 		$.ajax('/api/eventos/add_participante/'+self.id()+'.json',
// 			{
// 			data : ko.toJSON(data),
// 			type : 'post',
// 			contentType: 'application/json',
// 			success: function(result) { 
// 				var participantes = self.participantes();
// 				ko.utils.arrayPushAll(participantes,[new Participante(result.consumable,self)]);
// 				self.participantes.valueHasMutated();
// 				self.nomeParticipante(null);

// 			},
// 			error: function(result) { 
// 				console.log(result);
// 			}
// 		});
// 	};

// 	self.removeParticipante = function(participanteToRemove){
// 		self.participantes.remove(participanteToRemove);
// 		self.participantes.valueHasMutated();
// 	}

	
// }

var idEvento = $('h3[data-id]').data('id');
Evento.load(idEvento,{
		participanteModel : ParticipanteEdit,
		callback : function(evento){
			ko.applyBindings(new ParticipantesIndex(evento),
			document.getElementById('ParticipantesModel'));
			}
		});
});