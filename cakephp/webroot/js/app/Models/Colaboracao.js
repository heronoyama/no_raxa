define(['knockout','gateway'],
		function(ko,Gatewa){
	
	function Colaboracao(data){
		var self = this;
		self.id = ko.observable(data.id);
		self.valor = ko.observable(parseInt(data.valor));
		self.participante = ko.observable(data.participante);
		self.consumable = ko.observable(data.consumivel);

		self.editing = ko.observable(false);
		self.edit = function() { 
			self.editing(true) 
		};

		self.subscribeValor = function(subscribeCallback){
			self.valor.subscribe(function(){
				subscribeCallback(self,function(){
					self.editing(false);
				});
			});
		}

		self.compareTo = function(other){
			var valor = self.valor();
			var otherValor = other.valor();
			if(valor == otherValor){
				var comparisonParticipante = self.participante().compareTo(other.participante());
				if(comparisonParticipante == 0)
					return comparisonParticipante;
				return self.consumable().compareTo(other.consumable());
			}
			return (valor < otherValor) ? -1 : 1;
		}

		self.toJson = ko.computed(function(){
			return {
					id : self.id(),
					paritcipantes_id : self.participante().id(),
					consumableS_id : self.consumable().id(),
					value : parseInt(self.valor())
					}
		});

	}

	return Colaboracao;
});