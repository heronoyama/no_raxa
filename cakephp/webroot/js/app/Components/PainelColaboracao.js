define(['knockout','controllers/ColaboracaoController'],function(ko,ColaboracaoController){

    function PainelColaboracao(idEvento,participanteController,consumivelController){
        var self = this;
        self.idEvento = ko.observable(idEvento);

        self.participanteController = ko.observable(participanteController);
        self.consumivelController = ko.observable(consumivelController);
        self.colaboracaoController = ko.observable(new ColaboracaoController(self.idEvento()));
        self.colaboracaoController().loadColaboracoes();

        self.participanteFoco = ko.observable();
        self.consumivelFoco = ko.observable();
        
        self.participanteSelecionado = function(participante){
            self.participanteFoco(participante);
            self.consumivelFoco(null);
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

        self.colaboracaoDoParticipante = function(participante){
            if(self.nadaSelecionado())
                return {valor : ko.observable(0), editing: ko.observable(false), click : function(){} };
            if(self.participanteFoco())
                return {valor : ko.observable(0), editing: ko.observable(false), click : function(){} };

            return self.colaboracaoController().colaboracaoDado(participante,self.consumivelFoco());
        }

        self.colaboracaoDoConsumivel = function(consumivel){
            if(self.nadaSelecionado())
                return {valor : ko.observable(0), editing: ko.observable(false), click : function(){} };
            if(self.consumivelFoco())
                return {valor : ko.observable(0), editing: ko.observable(false), click : function(){} };

            return self.colaboracaoController().colaboracaoDado(self.participanteFoco(),consumivel);
        }

        self.nadaSelecionado = function(){
            return !self.participanteFoco() && !self.consumivelFoco();
        }

    }
    return PainelColaboracao;
});