define(['knockout','gateway'],function(ko,Gateway){

    function PainelListagem(){
        var self = this;
        self.texto = ko.observable("olá listagem");
    }

    function PainelConsumo(){
        var self = this;
        self.texto = ko.observable("ola consumos");
    }

    function PainelColaboracao(){
        var self = this;
        self.texto = ko.observable('olá colaboiração');
    }


    function DashboardEntidade(){
        var self = this;

        self.painelListagem = ko.observable(new PainelListagem());
        self.painelConsumo = ko.observable(new PainelConsumo());
        self.painelColaboracao = ko.observable(new PainelColaboracao());

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