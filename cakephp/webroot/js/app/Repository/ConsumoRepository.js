define(['knockout','models/Consumo','models/Participante','models/Consumivel','gateway'],
    function(ko,Consumo,Participante,Consumivel,Gateway){

    function ConsumoRepository(idEvento,params){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        self.params = params;
        self.consumos = ko.observableArray([]);

        self.consumosDoParticipante = function(participante){
            return self.consumos().filter(function(each){
                return each.participante().id() == participante.id();
            });
        }

        self.consumosDoConsumivel = function(consumivel){
            return self.consumos().filter(function(each){
                return each.consumable().id() == consumivel.id();
            });
        }

        self.novo = function(data,callback){
            var gatewayOptions = {
				controller: 'consumptions',
				data: data,
				callback : function(result){
                    var consumption = result.consumption;
					var participante = consumption.participante;
					var consumable = consumption.consumable;
					consumption.participante = new Participante.model(participante)
					consumption.consumivel = new Consumivel.model(consumable);
					var consumo = new Consumo.model(consumption);

                    var consumos = self.consumos();
                    ko.utils.arrayPushAll(consumos,[consumo]);
                    self.consumos.valueHasMutated();
					callback(consumo);
				}
            }
            
			Gateway.new(gatewayOptions);
        }

        self.delete = function(consumo,callback){
            var result = confirm("Deseja realmente remover esse consumo?");
			if(!result)
                return;
            
            var gatewayOptions = {
				controller: 'consumptions',
				id:consumo.id(),
				callback : function(result){
                    self.consumos.remove(consumo);
                    self.consumos.valueHasMutated();
                    if(callback)
					    callback(consumo);
				}
			};
            Gateway.delete(gatewayOptions);
            
        };

        function load(){
            var gatewayOptions = {
                idEvento : self.idEvento(),
                controller: 'consumptions',
                callback : function(allData){
                        var consumos = allData.consumptions.map(function(data){
						var dataItem = {
							id: data.id,
							participante: new Participante.model(data.participante),
							consumivel: new Consumivel.model(data.consumable)
						};
						return new Consumo.model(dataItem);
					});
                    self.consumos(consumos);
                }
            };
            if(self.params)
                gatewayOptions.params = 'include=('+self.params.join(',')+')';

			Gateway.getAll(gatewayOptions);
        }

        load();

    }

    return {
        initialize : function(idEvento, params){
            return new ConsumoRepository(idEvento,params);
        }
    }

});