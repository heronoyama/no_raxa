define(['knockout'],function(ko){
    function PainelListagem(participanteController,consumivelController){
        var self = this;
        
        self.participantesController = ko.observable(participanteController);
        self.consumivelController = ko.observable(consumivelController);
    };

    return PainelListagem;

});