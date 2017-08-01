requirejs(['knockout','models/Participante'],function(ko,Participante){

function ParticipanteModel(data,eventosModel){
	var self=this;
	self.participante = ko.observable(new Participante(data));
	this.editing = ko.observable(false);

	this.eventosModel = ko.observable(eventosModel);

	this.edit = function() { this.editing(true) };

};

function EventoModel(idEvento){
	var self = this;
	self.participantes = ko.observableArray([]);
	self.id = ko.observable(idEvento);
	self.nomeParticipante =  ko.observable();

	self.criaParticipante = function(){
		var data = {nome: self.nomeParticipante()};
		$.ajax('/api/eventos/add_participante/'+self.id()+'.json',
			{
			data : ko.toJSON(data),
			type : 'post',
			contentType: 'application/json',
			success: function(result) { 
				var participantes = self.participantes();
				ko.utils.arrayPushAll(participantes,[new Participante(result.consumable,self)]);
				self.participantes.valueHasMutated();
				self.nomeParticipante(null);

			},
			error: function(result) { 
				console.log(result);
			}
		});
	};

	self.removeParticipante = function(participanteToRemove){
		self.participantes.remove(participanteToRemove);
		self.participantes.valueHasMutated();
	}

	
}

var idEvento = $('h3[data-id]').data('id');
ko.applyBindings(new EventoModel(idEvento),document.getElementById('EventoModel'));

});

