define(['knockout'],function(ko){

    function Relatorio(data){
        var self = this;
        self.nome = ko.observable(data.nome);
        self.idEvento = ko.observable(data.idEvento);
        self.url = ko.observable(data.url);

        self.getUrl = ko.computed(function(){
            return '/csv/eventos/'+self.idEvento()+'/divisorDespesas/' + self.url();
        });
    }

    function PainelRelatorio(params){
        var self = this;
        self.idEvento = ko.observable(params.idEvento);

        self.relatorios = ko.observableArray([]);
        self.selectedRelatorio = ko.observable();

        self.computedUrl = ko.computed(function(){
            if(!self.selectedRelatorio())
                return '';
            return self.selectedRelatorio().getUrl();
        });

        function initialize(){
            var relatorios = [];
            relatorios.push(new Relatorio({nome : 'Relatório balanço final', url : 'balancoFinalParticipantes.csv',idEvento: self.idEvento()}));
            relatorios.push(new Relatorio({nome : 'Relatório custo por recurso', url : 'valorPorRecursoAnalitico.csv',idEvento: self.idEvento()}));
            relatorios.push(new Relatorio({nome : 'Matriz Consumo', url : 'matrizConsumo.csv',idEvento: self.idEvento()}));
            relatorios.push(new Relatorio({nome : 'Matriz Colaborações', url : 'matrizColaboracao.csv',idEvento: self.idEvento()}));
            self.relatorios(relatorios);
        };

        initialize();

    }

     function initializeComponente(){
		 ko.components.register('painel-relatorio', {
	        viewModel: PainelRelatorio,
	        template: {require: 'text!templates/PainelRelatorio.html'}
	    });
    }

    return {
		loadComponent: initializeComponente
	};

});