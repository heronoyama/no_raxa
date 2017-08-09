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
					paritcipantes_id : self.participante().id(),
					consumableS_id : self.consumable().id()
					}
		});

		self.save = function(callback){
			var gatewayOptions = {
				controller: 'consumptions',
				data: self.toJson(),
				callback : function(result){
					callback(self);
				}
			}
			
			Gateway.new(gatewayOptions);
		}

		self.delete = function(callback){
			var gatewayOptions = {
				controller: 'consumptions',
				id:self.id(),
				callback : function(result){
					callback(self);
				}
			};
			Gateway.delete(gatewayOptions);
		}

	}

	return {
		model : Consumo,
		loadAll: function(options){
			var gatewayOptions = {
				idEvento : options.idEvento,
				controller: 'consumptions',
				callback : function(allData){
					
					var model = options.model ? options.model : Consumo;
					var consumos = allData.consumptions.map(function(data){
						var dataItem = {
							id: data.id,
							participante: new Participante.model(data.participante),
							consumivel: new Consumivel.model(data.consumable)
						};
						return new model(dataItem);
					});
                    
                    options.callback(consumos);
				}
			}
            if(options.params)
			   gatewayOptions.params = options.params;
			
			Gateway.getAll(gatewayOptions);
		},
		new: function(options){
			var gatewayOptions = {
				controller: 'consumptions',
				data: options.data,
				callback : function(result){
					var model = options.model ? options.model : Consumo;
					var consumption = result.consumption;
					var participante = consumption.participante;
					var consumable = consumption.consumable;
					consumption.participante = new Participante.model(participante)
					consumption.consumivel = new Consumivel.model(consumable);
					var consumo = new model(consumption);
					options.callback(consumo);
				}
			}
			Gateway.new(gatewayOptions);
		},

		disponiveisParaParticipante: function(options){
			var callback = options.callback;
			options.callback = function(){
				
			}
		}
	}
});