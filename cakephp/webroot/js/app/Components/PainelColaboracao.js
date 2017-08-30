define(['knockout'],function(ko){
 function PainelColaboracao(idEvento,repository){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        self.repository = ko.observable(repository);

        self.participanteFoco = ko.observable();
        self.consumivelFoco = ko.observable();
        self.colaboracoes = ko.observableArray([]);

          self.participanteSelecionado = function(participante){
            self.participanteFoco(participante);
            self.consumivelFoco(null);
            var colaboracoes = self.repository().colaboracaoRepository().colaboracoesDoParticipante(self.participanteFoco());
            self.colaboracoes(colaboracoes);
        }

        self.consumivelSelecionado = function(consumivel){
            self.consumivelFoco(consumivel);
            self.participanteFoco(null);
        }

         self.getCssParticipante = function(participante){
            if(!self.participanteFoco())
                return self.consumivelFoco()? 'marked': '';
            
            return self.participanteFoco() == participante ? "active" : '';
            
        }

        self.getCssConsumivel = function(consumivel){
            if(!self.consumivelFoco())
                return self.participanteFoco()? 'marked' : '';
            
            return self.consumivelFoco() == consumivel ? "active" : '';
        }
    }
    return PainelColaboracao;
});