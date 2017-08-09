define(['knockout'],function(ko){
	return function Detalhamento(params){
		var self= this;
		self.id = ko.observable("");
		self.nome=ko.observable("");
		self.consumptions = ko.observableArray([]);
		self.collaborations = ko.observableArray([]);

		self.load = function(data){
			self.id(data.id);
			self.nome(data.nome);
			self.consumptions(self.loadConsumptions(data.consumptions));
			self.collaborations(self.loadCollaborations(data.collaborations));
		}

		self.loadConsumptions = function(consumptions){
			return consumptions.map(self.mapConsumo);
		}

		self.loadCollaborations = function(collaborations){
			return collaborations.map(self.mapColaboracao);
		}

		self.mapColaboracao = function(data){
			return data;
		}

		self.mapConsumo = function(data){
			return data;
		}
	};
});