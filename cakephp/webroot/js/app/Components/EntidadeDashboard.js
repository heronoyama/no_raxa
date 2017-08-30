define(['knockout',
        'gateway',
        'components/PathUtils',
        'components/PainelListagem',
        'components/PainelConsumo',
        'components/PainelColaboracao',
        'repository/Repository',
        'controllers/ParticipanteController',
        'controllers/ConsumivelController',
        'controllers/ConsumoController'],
            function(ko,Gateway,PathUtils,PainelListagem,PainelConsumo,PainelColaboracao,Repository,ParticipanteController,ConsumivelController,ConsumoController){

    function DashboardEntidade(){
        var self = this;
    
        self.idEvento = ko.observable(PathUtils.extractEventoId());
        self.repository = ko.observable(Repository.initalize(self.idEvento(),['Consumptions','Collaborations']));

        self.participanteController = ko.observable(new ParticipanteController(self.idEvento()));
        self.consumivelController = ko.observable(new ConsumivelController(self.idEvento()));
        self.consumoController = ko.observable(new ConsumoController(self.idEvento()));
        self.consumoController().loadConsumos();

        self.painelListagem = ko.observable(new PainelListagem(self.participanteController(),self.consumivelController()));
        self.painelConsumo = ko.observable(new PainelConsumo(self.idEvento(),self.participanteController(),self.consumivelController(),self.consumoController()));
        self.painelColaboracao = ko.observable(new PainelColaboracao(self.idEvento(),self.repository()));

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