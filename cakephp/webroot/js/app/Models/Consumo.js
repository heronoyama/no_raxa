define(['knockout','gateway','models/Participante','models/Consumivel'],
		function(ko,Gateway,Participante,Consumivel){
	
	function Consumo(data){
		var self = this;
		self.id = ko.observable(data.id);
		self.participante = ko.observable(Participante.factory.create(data.participante));
		self.consumable = ko.observable(Participante.factory.create(data.consumable));

		self.compareTo = function(other){
			var comparisonParticipante = self.participante().compareTo(other.participante());
			if(comparisonParticipante == 0)
				return comparisonParticipante;
			return self.consumable().compareTo(other.consumable());
			
		}

		self.toJson = ko.computed(function(){
			return {
					id : self.id(),
					paritcipantes_id : self.participante().id(),
					consumableS_id : self.consumable().id()
					}
		});

		self.delete = function(options){
			var gatewayOptions = {
				controller: 'consumptions',
				id:self.id(),
				callback : function(result){
					options.callback(self);
				}
			};
			Gateway.delete(gatewayOptions);
		}
	}

	function Factory(){
		var self = this;
		self.loadAll = function(options){
			var gatewayOptions = {
				idEvento : options.idEvento,
				controller: 'consumptions',
				callback : function(allData){
					var consumos = [];
                    var model = options.model ? options.model : Consumo;
                    for(var index in allData.consumptions){
                    	var data = allData.consumptions[index];
                    	consumos.push(new model(data));
                    }
                    
                    options.callback(consumos);
				}
			}
            if(options.params)
			   gatewayOptions.params = options.params;
			
			Gateway.getAll(gatewayOptions);
		}
		
		self.new = function(options){
			var gatewayOptions = {
				controller: 'consumptions',
				data: options.data,
				callback : function(result){
					var model = options.model ? options.model : Consumo;
					var consumo = new model(result.consumption);
					options.callback(consumo);
				}
			}
			Gateway.new(gatewayOptions);
		}
		
	}

	return {
		model : Consumo,
		factory : new Factory()
		}
});