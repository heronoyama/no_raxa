function Participante(data,eventosModel){
	var self=this;
	self.id = ko.observable(data.id);
	self.nome = ko.observable(data.nome);
	this.editing = ko.observable(false);
	this.eventosModel = ko.observable(eventosModel);

	this.edit = function() { this.editing(true) };

	self.deletar = function(){
		$.ajax('/api/participantes/'+self.id()+'.json',{
			type : 'delete',
			contentType: 'application/json',
			success: function(result) { 
				alert("Participante deletado com sucesso!");
				self.eventosModel().removeParticipante(self);
			},
			error: function(result) { 
				console.log(result);
			}
		});
	};

	self.nome.subscribe(function(newNome){
		var data = ko.toJSON( {nome: newNome});
		$.ajax('/api/participantes/'+self.id()+'.json',
			{
			data : ko.toJSON(data),
			type : 'put',
			contentType: 'application/json',
			success: function(result) { 
				alert("nome atualizado com sucesso!");
			},
			error: function(result) { 
				console.log(result);
			}
		});
	});


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

	$.getJSON(
		'/api/eventos/'+self.id()+'.json',
		function(allData){
			var mappedParticipantes = $.map(allData.evento.participantes,function(item){
				return new Participante(item,self);
			});
			self.participantes(mappedParticipantes);
		});
}

var idEvento = $('h3[data-id]').data('id');
ko.applyBindings(new EventoModel(idEvento),document.getElementById('EventoModel'));