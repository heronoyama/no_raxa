requirejs(['knockout','components/PathUtils','models/Consumivel'],function(ko,PathUtils,Consumivel){

function ConsumablesIndex(idEvento){
	var self = this;
	self.idEvento = ko.observable(idEvento);
	self.consumiveis = ko.observableArray([]);

	self.nomeConsumivel =  ko.observable();

	self.criaConsumable = function(){
		var novoConsumivel = new Consumivel.editModel({nome : self.nomeConsumivel(),idEvento:self.idEvento()});
		novoConsumivel.save(function(consumivel){
			var consumiveis = self.consumiveis();
			ko.utils.arrayPushAll(consumiveis,[consumivel]);
			self.consumiveis(consumiveis);
			self.consumiveis.valueHasMutated();
			self.nomeConsumivel(null);
		})
	};

	self.delete = function(consumivelToDelete){
		consumivelToDelete.delete(function(consumivel){
                self.consumiveis.remove(consumivel);
                self.consumiveis.valueHasMutated();
            });
	};

	function load(){
		var options = {
			idEvento : self.idEvento(),
			model : Consumivel.editModel,
			callback : function(consumiveis){
				self.consumiveis(consumiveis);
			}
		};

		Consumivel.loadAll(options);
	}

	load();

};


var idEvento = PathUtils.extractEventoId();
ko.applyBindings(new ConsumablesIndex(idEvento),document.getElementById('ConsumablesModel'));

});
