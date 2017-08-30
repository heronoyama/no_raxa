define(['knockout'],function(ko){
    function PainelListagem(participanteController,repository){
        var self = this;
        self.repository = ko.observable(repository);

        self.participantesController = ko.observable(participanteController);
    };

    return PainelListagem;

});