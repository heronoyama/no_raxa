define(['knockout','models/Consumo','models/Participante','models/Consumivel','gateway'],function(ko,Consumo,Participante,ConsumivelGateway){

    function ConsumoRepository(idEvento,params){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        self.params = params;
        self.consumos = ko.observableArray([]);

        self.novo = function(data,callback){
            var gatewayOptions = {
				controller: 'consumptions',
				data: data,
				callback : function(result){
                    var consumo = new Consumo(consumption);
                    var consumos = self.consumos();
                    ko.utils.arrayPushAll(consumos,[consumo]);
                    self.consumos.valueHasMutated();
					callback(consumo);
				}
            }
            
			Gateway.new(gatewayOptions);
        }

        self.delete = function(consumo){
            var result = confirm("Deseja realmente remover esse consumo?");
			if(!result)
                return;
            
            var gatewayOptions = {
				controller: 'consumptions',
				id:consumo.id(),
				callback : function(result){
                    self.consumos.remove(consumo);
                    self.consumos.valueHasMutated();
					callback(self);
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
							participante: new Participante(data.participante),
							consumivel: new Consumivel(data.consumable)
						};
						return new Consumo(dataItem);
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