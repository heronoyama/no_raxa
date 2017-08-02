requirejs(['knockout','models/Evento','models/Consumivel'],function(ko,Evento,Consumivel){

function ConsumivelEdit(data){
	var self = this;
	Consumivel.call(self,data);

	self.editing = ko.observable(false);

	self.edit = function() { 
		self.editing(true) 
	};

	self.nome.subscribe(function(newNome){
		self.save(function(){
			self.editing(false);
		});
	});

}

function ConsumablesIndex(evento){
	var self = this;
	self.evento = ko.observable(evento);
	self.nomeConsumivel =  ko.observable();

	self.criaConsumable = function(){
		var consumivel = new ConsumivelEdit({nome : self.nomeConsumivel()});
		self.evento().addConsumivel(consumivel,function(){
			self.nomeConsumivel(null);
		});
	};

	self.delete = function(consumivelToDelete){
		self.evento().removeConsumivel(consumivelToDelete);
	};

};


var idEvento = $('h3[data-id]').data('id');

//TODO conditional loading
Evento.load(idEvento,{
		consumivelModel : ConsumivelEdit,
		callback : function(evento){
			ko.applyBindings(new ConsumablesIndex(evento),
			document.getElementById('ConsumablesModel'));
			}
		});
});
