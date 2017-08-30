define(['knockout','models/Colaboracao','repository/ColaboracaoRepository'],function(ko,Colaboracao,ColaboracaoRepository){
    
    function ColaboracaoController(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);

        self.colaboracoes = ko.observableArray([]);
        self.repository = ko.observable();

        self.loadColaboracoes = function(callback,params){
            var options = {
                editMode:true,
                callback : function(colaboracoes){
                    self.colaboracoes(colaboracoes);
                    if(callback)
                        callback(colaboracoes);
                }
            }
            if(params)
                options.params = params;

            self.repository().all(options);
        }

        self.colaboracaoDado = function(participante,consumivel){
            var colaboracao = self.colaboracoes().find(function(each){
                return each.participante().id() == participante.id() && each.consumivel().id() == consumivel.id();
            });
            return colaboracao ? colaboracao : self.colaboracaoFake(participante,consumivel);
        }

        self.colaboracaoFake = function(participante,consumivel){
            return new Colaboracao({valor: 0 , participante: participante, consumivel : consumivel});
        }

        self.sortColaboracoes = function(sort){
            self.colaboracoes.sort(sort);
        }

        self.novaColaboracao = function(participante,consumivel,valor,callback){
            var data = {
                eventos_id : self.idEvento(),
                participantes_id :participante.id(),
                consumables_id : consumivel.id(),
                value: parseInt(valor)
            };
            
            //TODO alterar para passar a entidade ao invés de data
            self.repository().novaColaboracaoEdit(data,function(colaboracao){
                var colaboracoes = self.colaboracoes();

                var found = self.colaboracoes().find(function(each){
                    return each.id() == colaboracao.id();
                });
                if(found){
                    found.valor(colaboracao.valor());
                    return;
                }
                
                ko.utils.arrayPushAll(colaboracoes,[colaboracao]);
                self.colaboracoes(colaboracoes);
                self.colaboracoes.valueHasMutated();
                if(callback)
                    callback(colaboracao);
            });
                
        }


        self.delete = function(colaboracao){
            self.repository().delete(colaboracao,function(consumo){
                self.colaboracoes.remove(colaboracao);
                self.colaboracoes.valueHasMutated();
            });
        }

        function load(){
            self.repository(new ColaboracaoRepository(self.idEvento()));
        }
        load();

    }

    return ColaboracaoController;

});