function Consumable(data,eventosModel){
	var self=this;
	self.id = ko.observable(data.id);
	self.nome = ko.observable(data.nome);
	this.editing = ko.observable(false);
	this.eventosModel = ko.observable(eventosModel);

	this.edit = function() { this.editing(true) };

	self.deletar = function(){
		$.ajax('/api/consumables/'+self.id()+'.json',{
			type : 'delete',
			contentType: 'application/json',
			success: function(result) { 
				alert("Consumable deletado com sucesso!");
				self.eventosModel().removeConsumable(self);
			},
			error: function(result) { 
				console.log(result);
			}
		});
	};

	self.nome.subscribe(function(newNome){
		var data = ko.toJSON( {nome: newNome});
		$.ajax('/api/consumables/'+self.id()+'.json',
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
	self.consumiveis = ko.observableArray([]);
	self.id = ko.observable(idEvento);
	self.nomeConsumivel =  ko.observable();

	

	self.criaConsumable = function(){
		var data = ko.toJSON( {nome: self.nomeConsumivel()});
		$.ajax('/api/eventos/add_consumable/'+self.id()+'.json',
			{
			data : ko.toJSON(data),
			type : 'post',
			contentType: 'application/json',
			success: function(result) { 
				var consumiveis = self.consumiveis();
				ko.utils.arrayPushAll(consumiveis,[new Consumable(result.consumable,self)]);
				self.consumiveis.valueHasMutated();
				self.nomeConsumivel(null);

			},
			error: function(result) { 
				console.log(result);
			}
		});
	};

	self.removeConsumable = function(consumableToRemove){
		self.consumiveis.remove(consumableToRemove);
		self.consumiveis.valueHasMutated();
	}

	$.getJSON(
		'/api/eventos/'+self.id()+'.json',
		function(allData){
			var mappedConsumables = $.map(allData.evento.consumables,function(item){
				return new Consumable(item,self);
			});
			self.consumiveis(mappedConsumables);
		});

}

var idEvento = $('h3[data-id]').data('id');
ko.applyBindings(new EventoModel(idEvento),document.getElementById('EventoModel'));