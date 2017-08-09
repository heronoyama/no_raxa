define(['knockout','gateway','models/Participante','models/Consumivel'],
		function(ko,Gateway,Participante,Consumivel){
	
	function Colaboracao(data){
		var self = this;
		self.id = ko.observable(data.id);
		self.valor = ko.observable(parseInt(data.value));
		self.participante = ko.observable(Participante.factory.create(data.participante));
		self.consumable = ko.observable(Participante.factory.create(data.consumable));

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

		self.updateValue = function(options){
			var gatewayOptions = {
				controller: 'collaborations',
				id: self.id(),
				data : self.toJson(),
				callback: function(result){
					options.callback(self);
				}
			};
			Gateway.update(gatewayOptions);
		}

		self.delete = function(options){
			var gatewayOptions = {
				controller: 'collaborations',
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
				controller: 'collaborations',
				callback : function(allData){
					var colaboracoes = [];
                    var model = options.model ? options.model : Colaboracao;
                    for(var index in allData.collaborations){
                    	var data = allData.collaborations[index];
                    	colaboracoes.push(new model(data));
                    }
                    
                    options.callback(colaboracoes);
				}
			}
            if(options.params)
			   gatewayOptions.params = options.params;
			
			Gateway.getAll(gatewayOptions);
		}

		self.new = function(options){
			var gatewayOptions = {
				controller: 'collaborations',
				data: options.data,
				callback : function(result){
					var model = options.model ? options.model : Colaboracao;
					var colaboracao = new model(result.collaboration);
					options.callback(colaboracao);
				}
			}
			Gateway.new(gatewayOptions);
		}
		
	}

	return {
		model : Colaboracao,
		factory : new Factory()
		}
});