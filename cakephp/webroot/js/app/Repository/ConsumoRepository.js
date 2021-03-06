define(['knockout','gateway','models/Participante','models/Consumivel','models/Consumo'],
    function(ko,Gateway,Participante,Consumivel,Consumo){

    function ConsumoRepository(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        
        self.all = function(options){
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
                    options.callback(consumos);
                }
            };
            if(options.params)
                gatewayOptions.params = options.params;

            Gateway.getAll(gatewayOptions);
        }

        self.novo = function(data,callback){
            var gatewayOptions = {
                controller: 'consumptions',
                data: data,
                callback : function(result){
                    var consumption = result.consumption;
                    var participante = consumption.participante;
                    var consumable = consumption.consumable;
                    consumption.participante = new Participante(participante)
                    consumption.consumivel = new Consumivel(consumable);
                    var consumo = new Consumo(consumption);
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
                    callback(consumo);
                }
            };
            
            Gateway.delete(gatewayOptions);
            
        };
    }
    return ConsumoRepository;


});