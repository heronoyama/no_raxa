define(['knockout','models/Colaboracao','repository/ColaboracaoRepository'],function(ko,Colaboracao,ColaboracaoRepository){
    
    function ColaboracaoController(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);

        self.colaboracoes = ko.observableArray([]);
        self.repository = ko.observable();
        self.mapaColaboracoes = ko.observableArray([]);

        self.loadColaboracoes = function(options){
            var repositoryOptions = {
                editMode:true,
                callback : function(colaboracoes){
                    self.colaboracoes(colaboracoes);
                    self.mapColaboracoes(colaboracoes);
                    if(options && options.callback)
                        callback(colaboracoes);
                }
            }
            if(options && options.params)
                repositoryOptions.params = options.params;

            self.repository().all(repositoryOptions);
        }

        self.mapColaboracoes = function(colaboracoes){
            var mapaColaboracoes = [];
            colaboracoes.forEach(function(colaboracao){
                var participante = colaboracao.participante().nome();
                var consumivel = colaboracao.consumivel().nome();

                var found = false;
                for(var nome in mapaColaboracoes)
                    found = found || nome==participante;
                if(!found)
                    mapaColaboracoes[participante] = [];

                mapaColaboracoes[participante][consumivel] = colaboracao;
                
            });
            self.mapaColaboracoes(mapaColaboracoes);
        }

        self.colaboracaoDado = function(participante,consumivel){
            var colaboracoesDoParticipante = self.mapaColaboracoes()[participante.nome()];
            if(!colaboracoesDoParticipante)
                return self.colaboracaoFake(participante,consumivel);
            var colaboracao = colaboracoesDoParticipante[consumivel.nome()];
            return colaboracao ? colaboracao : self.colaboracaoFake(participante,consumivel);
        }

        self.colaboracaoFake = function(participante,consumivel){
            var data = {valor: 0,idEvento:self.idEvento(), participante: participante, consumivel : consumivel};
            return self.repository().novaColaboracaoFake(data,self.putColaboracao);
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
            
            self.novaColaboracaoData(data,callback);    
        }

        self.novaColaboracaoData = function(data,callback){
            //TODO alterar para passar a entidade ao invés de data
            self.repository().novaColaboracaoEdit(data,function(colaboracao){
                self.putColaboracao(colaboracao);
                if(callback)
                    callback(colaboracao);
            });
        }

        self.putColaboracao = function(colaboracao){
             var colaboracoes = self.colaboracoes();

            var found = self.colaboracoes().find(function(each){
                return each.id() == colaboracao.id();
            });
            if(found && colaboracao.id()){
                found.valor(colaboracao.valor());
                return;
            }
            
            ko.utils.arrayPushAll(colaboracoes,[colaboracao]);
            self.colaboracoes(colaboracoes);
            self.colaboracoes.valueHasMutated();
            //TODO deve ter ficado pesado pa carai
            self.mapColaboracoes(self.colaboracoes());
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