define(['knockout','gateway','components/PathUtils',
        'components/PainelListagem',
        'components/PainelConsumo',
        'components/PainelColaboracao',
        'controllers/ParticipanteController',
        'controllers/ConsumivelController'],
    function(ko,Gateway,PathUtils,
        PainelListagem,
        PainelConsumo,
        PainelColaboracao,
        ParticipanteController,
        ConsumivelController){


    function DashboardEntidade(){
        var self = this;
    
        self.idEvento = ko.observable(PathUtils.extractEventoId());

        self.participanteController = ko.observable(new ParticipanteController(self.idEvento()));
        self.consumivelController = ko.observable(new ConsumivelController(self.idEvento()));

        self.painelListagem = ko.observable(new PainelListagem(self.participanteController(),self.consumivelController()));
        self.painelConsumo = ko.observable(new PainelConsumo(self.idEvento(),self.participanteController(),self.consumivelController()));
        self.painelColaboracao = ko.observable(new PainelColaboracao(self.idEvento(),self.participanteController(),self.consumivelController()));

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