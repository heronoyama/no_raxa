define(['knockout','gateway','models/Participante','models/Consumivel','models/Colaboracao'],
function(ko,Gateway,Participante,Consumivel,Colaboracao){

    function ColaboracaoRepository(idEvento,params){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        self.params = params;
        self.colaboracoes = ko.observableArray([]);

        self.colaboracoesDoParticipante = function(participante){
            return self.colaboracoes().filter(function(each){
                return each.participante().id() == participante.id();
            })
        }

        function load(){
            var gatewayOptions = {
                idEvento : self.idEvento(),
                controller: 'collaborations',
                callback : function(allData){
                        var colaboracoes = allData.collaborations.map(function(data){
						var dataItem = {
							id: data.id,
							participante: new Participante.model(data.participante),
                            consumable: new Consumivel.model(data.consumable),
                            value: data.valor
						};
						return new Colaboracao.model(dataItem);
					});
                    self.colaboracoes(colaboracoes);
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
            return new ColaboracaoRepository(idEvento,params);
        }
    }

});