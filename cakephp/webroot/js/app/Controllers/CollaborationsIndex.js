requirejs(['knockout',
			'controllers/ColaboracaoController',
			'repository/ParticipanteRepository',
			'repository/ConsumivelRepository',
			'components/PathUtils'],
	function(ko,ColaboracaoController,ParticipanteRepository,ConsumivelRepository,PathUtils){

	function CollaborationsIndexModel(idEvento){
		var self = this;
		//TODO quebrar em mais classes
		self.idEvento = ko.observable(idEvento);
		
		self.controller = ko.observable(new ColaboracaoController(idEvento));

		self.participantes = ko.observableArray([]);
		self.consumiveis = ko.observableArray([]);

		self.selectedParticipantes = ko.observableArray([]);
		self.selectedConsumiveis = ko.observableArray([]);

		self.novoParticipante = ko.observable();
		self.novoConsumivel = ko.observable();
		self.novoValor = ko.observable();

		self.novaColaboracao = function(){
			if(!self.novoParticipante() || !self.novoConsumivel())
				return;
			var valor = self.novoValor()? self.novoValor() : 0;
			self.controller().novaColaboracao(self.novoParticipante(),self.novoConsumivel(),valor,function(colaboracao){
					if(self.isFiltered()){
						self.clearFilter();
				}
			});

		}

		self.isFiltered = ko.observable(false);

		self.clearFilter = function(){
			self.isFiltered(false);
			self.selectedConsumiveis([]);
			self.selectedParticipantes([]);
			loadColaboracoes();
		}

		self.filterConsumiveis = ko.computed(function(){
			if(self.selectedConsumiveis().length == 0)
				return [];
			if(self.selectedConsumiveis().length ==1 && !self.selectedConsumiveis()[0])
				return [];

			var ids = [];
			self.selectedConsumiveis().forEach(function(consumivel){
				ids.push(consumivel.id());
			})
			return ['consumiveis=in('+ids.join(',')+')'];

		});

		self.filterParticipantes = ko.computed(function(){
			if(self.selectedParticipantes().length == 0)
				return [];
			if(self.selectedParticipantes().length ==1 && !self.selectedParticipantes()[0])
				return [];

			var ids = [];
			self.selectedParticipantes().forEach(function(participante){
				ids.push(participante.id());
			})
			return ['participantes=in('+ids.join(',')+')'];

		});

		self.sortByConsumiveis = function(){
			self.controller().sortColaboracoes(function(left,right){
				return left.consumivel().compareTo(right.consumivel());
			});
		}

		self.sortByParticipantes = function(){
			self.controller().sortColaboracoes(function(left,right){
				return left.participante().compareTo(right.participante());
			});
		}

		self.sortByValores = function(){
			self.controller().sortColaboracoes(function(left,right){
				return left.compareTo(right);
			});	
		}

		self.filtrar = function(){
			var filtros = self.filterConsumiveis();
			filtros.push(self.filterParticipantes());
			if(filtros.length <= 0)
				return self.loadColaboracoes();

			self.controller().loadColaboracoes(function(colaboracoes){
				self.isFiltered(true);
			},filtros.join('&'));

		}

		function loadColaboracoes(){
			self.controller().loadColaboracoes();
		}

		function load(){
			loadColaboracoes();
			new ParticipanteRepository(self.idEvento()).all({
				callback : function(participantes){
					self.participantes(participantes);
				}
			});

			new ConsumivelRepository(self.idEvento()).all({
				callback : function(consumiveis){
					self.consumiveis(consumiveis);
				}
			});
		}

		load();

	};

	var idEvento = PathUtils.extractEventoId();
	ko.applyBindings(new CollaborationsIndexModel(idEvento),document.getElementById('CollaborationsModel'));

	$(document).ready(function(){
		$("#filtro").accordion({collapsible:true,active:false});

	});
});