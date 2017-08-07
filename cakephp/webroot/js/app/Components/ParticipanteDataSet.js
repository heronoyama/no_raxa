define(['knockout'],function(ko){

	function DataItem(params){
		var self=this;
		self.id = ko.observable(params.id);
		self.nome = ko.observable(params.nome);
		self.valorColaborado = ko.observable(params.valor_colaborado);
		self.valorDevido = ko.observable(params.valor_devido);
		self.valorFinal = ko.observable(params.valor_final);
	}

	function ParticipanteDataSet(params){
		var self = this;

		self.idEvento = ko.observable(params.idEvento);
		self.dataSet = ko.observableArray([]);

		function load(){
			var url = "/api/eventos/"+self.idEvento()+"/divisor/balancoParticipantes.json";

			$.getJSON(url,
                function(allData){
                    var participantes = [];

                    for(var index in allData){
                    	var data = allData[index];
                    	participantes.push(new DataItem(data));
                    }
                    
                    self.dataSet(participantes);
            });

			$("#ValorFinalParticipante").accordion({
				collapsible:true,
				header:'h4',
				animate: 200});

		}

		load();
		
	};

	function initializeComponente(){
		 ko.components.register('participante-data-set', {
	        viewModel: ParticipanteDataSet,
	        template: {require: 'text!templates/Participante.html'}
	    });
	}

	return {
		loadComponent: initializeComponente,
		model : ParticipanteDataSet		
	}
});