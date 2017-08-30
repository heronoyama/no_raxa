define(['knockout','gateway','models/Consumivel'],function(ko,Gateway,Consumivel){
    function ConsumivelRepository(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);

        self.all = function(options){
            var gatewayOptions = {
				idEvento : self.idEvento(),
				controller: 'consumables',
				callback : function(allData){
					var model = options.editMode ? Consumivel.editModel : Consumivel.model;
					var consumiveis = allData.consumables.map(function(data){
						data.idEvento = options.idEvento;
						return new model(data);
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
                    var model  = editMode ? Consumivel.editModel : Consumivel.model;
                    var consumivel = new model(result.consumable);
                    callback(consumivel);
				}
            };
            
			Gateway.new(gatewayOptions);
        }

        self.update = function(consumivel){
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