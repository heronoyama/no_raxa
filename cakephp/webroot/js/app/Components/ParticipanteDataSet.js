define(['knockout'],function(ko){

	function DataItem(params){
		var self=this;
		self.id = ko.observable(params.id);
		self.nome = ko.observable(params.nome);
		self.valorColaborado = ko.observable(params.valor_colaborado);
		self.valorDevido = ko.observable(params.valor_devido);
		self.valorFinal = ko.observable(params.valor_final);

	}

	function Consumo(params){
		var self = this;
		self.consumivel = ko.observable(params.consumable);
		self.valorPorParticipante = ko.observable(params.valor_por_participante);
	}

	function Colaboracao(params){
		var self = this;
		self.consumivel = ko.observable(params.consumable);
		self.valorColaborado = ko.observable(params.valor_colaborado);
	}

	function DetalhamentoItem(params){
		var self= this;
		self.id = ko.observable("");
		self.nome=ko.observable("");
		self.consumptions = ko.observableArray([]);
		self.collaborations = ko.observableArray([]);

		self.load = function(data){
			self.id(data.id);
			self.nome(data.nome);
			self.consumptions(loadConsumptions(data.consumptions));
			self.collaborations(loadCollaborations(data.collaborations));
		}

		function loadConsumptions(consumptions){
			var consumiveis = [];
			for(var index in consumptions){
				var consumption = consumptions[index];
				consumiveis.push(new Consumo(consumption));
			}
			return consumiveis;
		}

		function loadCollaborations(collaborations){
			var colaboracoes = [];
			for(var index in collaborations){
				var colaboracao = collaborations[index];
				colaboracoes.push(new Colaboracao(colaboracao));
			}
			return colaboracoes;
		}

	}

	function ParticipanteDataSet(idEvento){
		var self = this;

		self.idEvento = ko.observable(idEvento);
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
				heightStyle:'content',
				animate: 200,
				active:false});

		}

		load();
		
	};

	function DetalhamentoParticipante (idEvento){
		var self = this;
		self.idEvento = ko.observable(idEvento);
		self.isVisible = ko.observable(false);
		self.detalhamento = ko.observable(new DetalhamentoItem());

		self.populateData = function(dataItem){
			var url = "/api/eventos/"+self.idEvento()+"/divisor/detalhamentoParticipante/"+dataItem.id()+".json";
			$.getJSON(url,
                function(allData){
                    self.detalhamento().load(allData);
                    self.isVisible(true);
            });
		}

		self.close = function(){
			self.isVisible(false);
		}

	}

	function Component(params){
		var self = this;
		self.participanteDataSet = ko.observable(new ParticipanteDataSet(params.idEvento));
		self.detalhamentoParticipante = ko.observable(new DetalhamentoParticipante(params.idEvento));

		self.detailParticipante = function(dataItem){
			self.detalhamentoParticipante().populateData(dataItem);
		}
	}

	function initializeComponente(){
		 ko.components.register('participante-data-set', {
	        viewModel: Component,
	        template: {require: 'text!templates/ParticipanteDataSet.html'}
	    });
	}

	return {
		loadComponent: initializeComponente
	}
});