define(['knockout','repository/ConsumoRepository'],function(ko,ConsumoRepository){

    function ConsumoController(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);

        self.consumos = ko.observableArray([]);
        self.repository = ko.observable();

        self.loadConsumos = function(options){
            var repositoryOptions = {
                callback : function(consumos){
                    self.consumos(consumos);
                    if(options && options.callback)
                        options.callback(consumos);
                }
            }
            if(options && options.params)
                repositoryOptions.params = options.params;

            self.repository().all(repositoryOptions);
        }

        self.sortConsumos = function(sort){
            self.consumos.sort(sort);
        }

        self.novoConsumoData = function(data,callback){
            self.repository().novo(data,function(consumo){
                var consumos = self.consumos();
                ko.utils.arrayPushAll(consumos,[consumo]);
                self.consumos(consumos);
                self.consumos.valueHasMutated();
                if(callback)
                    callback(consumo);
            });
        }

        self.novoConsumo = function(participante,consumivel,callback){
            var data = {
                eventos_id : self.idEvento(),
                participantes_id :participante.id(),
                consumables_id : consumivel.id()
            };
            
            self.novoConsumoData(data,callback);
                
        }

        self.delete = function(consumo){
            self.repository().delete(consumo,function(consumo){
                self.removeConsumo(consumo);
            });
        }

        self.removeConsumo = function(consumo){
            self.consumos.remove(consumo);
            self.consumos.valueHasMutated();
        }

        self.deleteCallback = function(consumo,callback){
            self.repository().delete(consumo,function(consumo){
                self.removeConsumo(consumo);
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
                return each.consumivel().id() == consumivel.id();
            });
        }


        function load(){
            self.repository(new ConsumoRepository(self.idEvento()));
        }

        load();

    }

      return ConsumoController;

});