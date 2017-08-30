define(['knockout','repository/ConsumoRepository'],function(ko,ConsumoRepository){

    function ConsumoController(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);

        self.consumos = ko.observableArray([]);
        self.repository = ko.observable();

        self.loadConsumos = function(callback,params){
            var options = {
                callback : function(consumos){
                    self.consumos(consumos);
                    if(callback)
                        callback(consumos);
                }
            }
            if(params)
                options.params = params;

            self.repository().all(options);
        }

        self.sortConsumos = function(sort){
            self.consumos.sort(sort);
        }

        self.novoConsumo = function(participante,consumivel,callback){
            var data = {
                eventos_id : self.idEvento(),
                participantes_id :participante.id(),
                consumables_id : consumivel.id()
            };
            
            self.repository().novo(data,function(consumo){
                var consumos = self.consumos();
                ko.utils.arrayPushAll(consumos,[consumo]);
                self.consumos(consumos);
                self.consumos.valueHasMutated();
                if(callback)
                    callback(consumo);
            });
                
        }

        self.delete = function(consumo,callback){
            self.repository().delete(consumo,function(consumo){
                self.consumos.remove(consumo);
                self.consumos.valueHasMutated();
                if(callback)
                    callback(consumo);
            });
        }

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


        function load(){
            self.repository(new ConsumoRepository(self.idEvento()));
        }

        load();

    }

      return ConsumoController;

});