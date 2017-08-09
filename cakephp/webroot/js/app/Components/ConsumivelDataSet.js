define(['knockout',
	'components/models/Detalhamento',
	'components/models/DataSet',
	'gateway'],
		function(ko,Detalhamento,DataSet,Gateway){

	function DataItem(params){
		var self=this;
		self.id = ko.observable(params.id);
		self.nome = ko.observable(params.nome);
		self.valorInvestido = ko.observable(params.valor_investido);
		self.valorPorParticipante = ko.observable(params.valor_por_participante);
	}

	function DetalhamentoConsumivel(params){
		var self= this;
		Detalhamento.call(self,params);

		self.mapConsumo = function(data){
			return {
				participante : ko.observable(data.participante),
				id : ko.observable(data.id)
			};
	}

		self.mapColaboracao = function(data){
			return {
				participante: ko.observable(data.participante),
				valorColaborado: ko.observable(data.valor_colaborado)
			};
		};
	}

	function ConsumiveisDataSet(idEvento){
		var self = this;

		self.loadCallback = function(allData){
				var consumiveis = allData.map(function(data){
            		return new DataItem(data);
            	});
            	self.dataSet(consumiveis);
		};

		self.loadMethod = function(){
			return Gateway.balancoConsumiveis;
		}

		self.element = "#BalancoConsumiveis";

		DataSet.call(self,idEvento);

	};

	function DetalhamentoConsumo(idEvento){
		
		var self = this;
		self.idEvento = ko.observable(idEvento);
		self.isVisible = ko.observable(false);
		self.detalhamento = ko.observable(new DetalhamentoConsumivel());

		self.populateData = function(dataItem){
   			Gateway.detalhamentoConsumivel({
   				idEvento: self.idEvento(),
   				idConsumivel: dataItem.id(),
   				callback: function(allData){
                    		self.detalhamento().load(allData);
                    	self.isVisible(true);
            			}
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