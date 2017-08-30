define(['knockout',
    'repository/ConsumivelRepository',
    // 'repository/ConsumoRepository',
    'repository/ColaboracaoRepository'], 
function(ko, ConsumivelRepository,ConsumoRepository,ColaboracaoRepository){
    
    function Repository(idEvento,params){
        var self = this;
        self.idEvento = idEvento;
        self.params = params;

        // self.consumivelRepository = ko.observable(ConsumivelRepository.initialize(self.idEvento,self.params));
        // self.consumoRepository = ko.observable(ConsumoRepository.initialize(self.idEvento,self.params));
        // self.colaboracaoRepository = ko.observable(ColaboracaoRepository.initialize(self.idEvento,self.params));

    }

    return {
        initalize : function(idEvento,params){
            return new Repository(idEvento,params);
        }
    }

});