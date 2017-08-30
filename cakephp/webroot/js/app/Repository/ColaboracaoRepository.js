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
                            return mapColaboracao(options,data);

					});
                    options.callback(colaboracoes);
                }
            };
            if(options.params)
                gatewayOptions.params = 'include=('+self.params.join(',')+')';

			Gateway.getAll(gatewayOptions);

        }

        function mapColaboracao(options,data){
            var dataItem = {
                id: data.id,
                participante: new Participante(data.participante),
                consumivel: new Consumivel(data.consumable),
                valor: data.value
            };
            var colaboracao = new Colaboracao(dataItem);
            if(options.editMode)
                colaboracao.subscribeValor(self.update);
            return colaboracao;
        }

        self.novaColaboracaoEdit = function(data,callback){
            self.novaColaboracao(data,true,callback);
        }

        self.novaColaboracao = function(data,editMode,callback){
            var gatewayOptions = {
				controller: 'collaborations',
				data: data,
				callback : function(result){
                    var options = { editMode : editMode };
					var colaboracao = mapColaboracao(options,result.collaboration);
                    
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
            var result = confirm("Deseja realmente deletar?");
			if(!result)
                return;
            
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