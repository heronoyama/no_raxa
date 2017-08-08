define(['knockout'],function(ko){
	function DataItem(params){
		var self=this;
		self.id = ko.observable(params.id);
		self.nome = ko.observable(params.nome);
		self.valorInvestido = ko.observable(params.valor_investido);
		self.valorPorParticipante = ko.observable(params.valor_por_participante);
	}

	function Consumo(params){
		var self=this;
		self.participante = ko.observable(params.participante);
		self.id = ko.observable(params.id);
	}

	function Colaboracao(params){
		var self=this;
		self.participante = ko.observable(params.participante);
		self.valorColaborado = ko.observable(params.valor_colaborado);
	}

	function DetalhamentoConsumivel(params){
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


	function ConsumiveisDataSet(idEvento){
		var self = this;

		self.idEvento = ko.observable(idEvento);
		self.dataSet = ko.observableArray([]);

		function load(){
			var url = "/api/eventos/"+self.idEvento()+"/divisor/balancoConsumiveis.json";

			$.getJSON(url,
                function(allData){
                    var consumiveis = [];

                    for(var index in allData){
                    	var data = allData[index];
                    	consumiveis.push(new DataItem(data));
                    }
                    
                    self.dataSet(consumiveis);
            });

			$("#BalancoConsumiveis").accordion({
				collapsible:true,
				header:'h4',
				heightStyle:'content',
				animate: 200,
				active:false});

		}

		load();
		
	};

	function DetalhamentoConsumo(idEvento){
		
		var self = this;
		self.idEvento = ko.observable(idEvento);
		self.isVisible = ko.observable(false);
		self.detalhamento = ko.observable(new DetalhamentoConsumivel());

		self.populateData = function(dataItem){
			var url = "/api/eventos/"+self.idEvento()+"/divisor/detalhamentoConsumivel/"+dataItem.id()+".json";
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
		self.consumiveisDataSet = ko.observable(new ConsumiveisDataSet(params.idEvento));
		self.detalhamentoConsumo = ko.observable(new DetalhamentoConsumo(params.idEvento));

		self.detailConsumivel = function(dataItem){
			self.detalhamentoConsumo().populateData(dataItem);
		}
	}

	function initializeComponente(){
		 ko.components.register('consumiveis-data-set', {
	        viewModel: Component,
	        template: {require: 'text!templates/ConsumivelDataSet.html'}
	    });
	}

	return {
		loadComponent: initializeComponente
	}

});