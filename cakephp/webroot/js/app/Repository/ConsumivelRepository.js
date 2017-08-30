define(['knockout','gateway','models/Consumivel'],function(ko,Gateway,Consumivel){
    function ConsumivelRepository(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);

        self.all = function(options){
            var gatewayOptions = {
				idEvento : self.idEvento(),
				controller: 'consumables',
				callback : function(allData){
					var consumiveis = allData.consumables.map(function(data){
						consumivel = new Consumivel(data);
						if(options.editMode){
                            consumivel.subscribeNome(self.update);
						}
						return consumivel;
					});
                    options.callback(consumiveis);
				}
			}
			if(options.params)
				gatewayOptions.params = options.params;
			
            Gateway.getAll(gatewayOptions);
        }

        self.novoConsumivelEdit = function(nome,callback){
            self.novoConsumivel(nome,true,callback);
        }

        self.novoConsumivel = function(nome,editMode,callback){
            var data = {
                eventos_id: self.idEvento(),
                nome: nome
            };
			var gatewayOptions = {
				controller: 'consumables',
				data: data,
				callback : function(result){
					var consumivel = new Consumivel(result.consumable);
					if(editMode)
						consumivel.subscribeNome(self.update);
                    callback(consumivel);
				}
            };
            
			Gateway.new(gatewayOptions);
        }

        self.update = function(consumivel,callback){
            var gatewayOptions = {
				controller: 'consumables',
				id: consumivel.id(),
				data : consumivel.toJson(),
				callback: function(result){
					callback(consumivel);
				}
			};

			Gateway.update(gatewayOptions);
        }

        self.delete = function(consumivelToDelete,callback){
            var result = confirm("Deseja realmente deletar?");
			if(!result)
                return;

			var gatewayOptions = {
				controller: 'consumables',
				id:consumivelToDelete.id(),
				callback : function(result){
					callback(consumivelToDelete);
				}
			};
			Gateway.delete(gatewayOptions);
		};

    }

    return ConsumivelRepository;

});