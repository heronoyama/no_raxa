define(['knockout',
        'components/PathUtils',
        'gateway',
        'models/ParticipantesRepository',
        'models/ConsumivelRepository'],
            function(ko,PathUtils,Gateway,ParticipantesRepository,ConsumivelRepository){

    function PainelListagem(participanteRepository,consumivelRepository){
        var self = this;
        self.participanteRepository = ko.observable(participanteRepository);
        self.consumivelRepository = ko.observable(consumivelRepository);
    }

    function PainelConsumo(participanteRepository,consumivelRepository){
        var self = this;
        self.participanteRepository = ko.observable(participanteRepository);
        self.consumivelRepository = ko.observable(consumivelRepository);

        self.participanteFoco = ko.observable();

        self.participanteSelecionado = function(participante){
            self.participanteFoco(participante);
        }

        self.isSelected = function(participante){
            return self.participanteFoco() == participante;
        };
    }

    function PainelColaboracao(participanteRepository,consumivelRepository){
        var self = this;
        self.participanteRepository = ko.observable(participanteRepository);
        self.consumivelRepository = ko.observable(consumivelRepository);
    }


    function DashboardEntidade(){
        var self = this;
    
        self.idEvento = ko.observable(PathUtils.extractEventoId());
        self.participanteRepository = ko.observable(new ParticipantesRepository(self.idEvento()));
        self.consumivelRepository = ko.observable(new ConsumivelRepository(self.idEvento()));

        self.painelListagem = ko.observable(new PainelListagem(self.participanteRepository(),self.consumivelRepository()));
        self.painelConsumo = ko.observable(new PainelConsumo(self.participanteRepository(),self.consumivelRepository()));
        self.painelColaboracao = ko.observable(new PainelColaboracao(self.participanteRepository(),self.consumivelRepository()));

        self.modoListagem = ko.observable(true);
        self.modoConsumo = ko.observable(false);
        self.modoColaboracao = ko.observable(false);

        self.setModoListagem = function(){
            self.modoListagem(true);
            self.modoConsumo(false);
            self.modoColaboracao(false);
        }

        self.setModoConsumo = function(){
            self.modoListagem(false);
            self.modoConsumo(true);
            self.modoColaboracao(false);
        }

        self.setModoColaboracao = function(){
            self.modoListagem(false);
            self.modoConsumo(false);
            self.modoColaboracao(true);
        }

    }

    function initializeComponente(){
		 ko.components.register('dashboard-entidade', {
	        viewModel: DashboardEntidade,
	        template: {require: 'text!templates/DashboardEntidade.html'}
	    });
    }
    
    return {
		loadComponent: initializeComponente
	}

});