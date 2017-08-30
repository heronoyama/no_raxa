define(['knockout','gateway','models/Colaboracao','models/Participante','models/Consumivel'],
function(ko, Gateway, Colaboracao,Participante,Consumivel){

    function ColaboracaoRepository(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);

        self.all = function(options){
             var gatewayOptions = {
                idEvento : self.idEvento(),
                controller: 'collaborations',
                callback : function(allData){
                        var colaboracoes = allData.collaborations.map(function(data){
						var dataItem = {
							id: data.id,
							participante: new Participante(data.participante),
                            consumable: new Consumivel(data.consumable),
                            value: data.valor
                        };
                        var model = options.ediMode ? Colaboracao.editModel : Colaboracao.model;
						return new model(dataItem);
					});
                    options.callback(colaboracoes);
                }
            };
            if(options.params)
                gatewayOptions.params = 'include=('+self.params.join(',')+')';

			Gateway.getAll(gatewayOptions);

        }

        self.novaColaboracaoEdit = function(data,callback){
            self.novaColaboracao(data,true,callback);
        }

        self.novaColaboracao = function(data,editMode,callback){
            var gatewayOptions = {
				controller: 'collaborations',
				data: data,
				callback : function(result){
					var model = editMode ? Colaboracao.model : Colaboracao.editModel;
					var colaboracao = new model(result.collaboration);
					callback(colaboracao);
				}
			}
			Gateway.new(gatewayOptions);
        }

        self.update = function(colaboracao,callback){
            var gatewayOptions = {
				controller: 'collaborations',
				id: colaboracao.id(),
				data : colaboracao.toJson(),
				callback: function(result){
					callback(colaboracao);
				}
			};
			Gateway.update(gatewayOptions);
        }

        self.delete = function(colaboracao,callback){
            var gatewayOptions = {
				controller: 'collaborations',
				id:colaboracao.id(),
				callback : function(result){
					callback(colaboracao);
				}
			};
			Gateway.delete(gatewayOptions);
        }

    }

    return ColaboracaoRepository;

});