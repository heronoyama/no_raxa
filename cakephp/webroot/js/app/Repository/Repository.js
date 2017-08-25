define(['knockout','repository/ParticipantesRepository','repository/ConsumivelRepository','repository/ConsumoRepository'], 
function(ko,ParticipantesRepository, ConsumivelRepository,ConsumoRepository){
    
    function Repository(idEvento,params){
        var self = this;
        self.idEvento = idEvento;
        self.params = params;

        self.participanteRepository = ko.observable(ParticipantesRepository.initialize(self.idEvento,self.params));
        self.consumivelRepository = ko.observable(ConsumivelRepository.initialize(self.idEvento,self.params));
        self.consumoRepository = ko.observable(ConsumoRepository.initialize(self.idEvento,self.params));
    }

    return {
        initalize : function(idEvento,params){
            return new Repository(idEvento,params);
        }
    }


});