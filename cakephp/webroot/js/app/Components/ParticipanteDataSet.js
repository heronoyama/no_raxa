define(['knockout',
	'components/models/Detalhamento',
	'components/models/DataSet',
	'gateway'],function(ko,Detalhamento,DataSet,Gateway){
	function DataItem(params){
		var self=this;
		self.id = ko.observable(params.id);
		self.nome = ko.observable(params.nome);
		self.valorColaborado = ko.observable(params.valor_colaborado);
		self.valorDevido = ko.observable(params.valor_devido);
		self.valorFinal = ko.observable(params.valor_final);

	}

	function DetalhamentoItem(params){
		var self= this;
		Detalhamento.call(self,params);

		self.mapConsumo = function(data){
			return { 
				consumivel: ko.observable(data.consumable),
				valorPorParticipante: 
					ko.observable(data.valor_por_participante)  
				};
		}

		self.mapColaboracao = function(data){
			return {
				consumivel: ko.observable(data.consumable),
				valorColaborado: ko.observable(data.valor_colaborado)
			};
		}
	}

	function ParticipanteDataSet(idEvento){
		var self = this;
		

		self.loadCallback = function(allData){
				var participantes = allData.map(
					function(item){return new DataItem(item)});
				self.dataSet(participantes);
		};

		self.loadMethod = function(){
			return Gateway.balancoParticipantes;
		}
		self.element = "#ValorFinalParticipante";

		DataSet.call(self,idEvento);

	};

	function DetalhamentoParticipante (idEvento){
		var self = this;
		self.idEvento = ko.observable(idEvento);
		self.isVisible = ko.observable(false);
		self.detalhamento = ko.observable(new DetalhamentoItem());

		self.populateData = function(dataItem){
			var options = {
				idEvento: self.idEvento(),
				idParticipante: dataItem.id(),
				callback: function(allData){
					self.detalhamento().load(allData);
                    self.isVisible(true);
				}
			};
			Gateway.detalhamentoParticipante(options);
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