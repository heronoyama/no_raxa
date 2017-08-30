define(['knockout','gateway','models/Participante','models/Consumivel'],
		function(ko,Gateway,Participante,Consumivel){
	
	function Consumo(data){
		var self = this;
		self.id = ko.observable();
		self.participante = ko.observable();
		self.consumable = ko.observable();

		self.updateData = function(data){
			if(!data)
				return;
			if(data.id)
				self.id(data.id);
			if(data.participante)
				self.participante(data.participante);
			if(data.consumivel)
				self.consumable(data.consumivel);
		}
		self.updateData(data);

		self.compareTo = function(other){
			var comparisonParticipante = self.participante().compareTo(other.participante());
			if(comparisonParticipante == 0)
				return comparisonParticipante;
			return self.consumable().compareTo(other.consumable());
			
		}

		self.toJson = ko.computed(function(){
			return {
					id : self.id(),
					participantes_id : self.participante().id(),
					consumables_id : self.consumable().id()
					}
		});

	}

	return Consumo;
});