requirejs(['knockout',
'repository/ParticipanteRepository',
'repository/ConsumivelRepository',
'components/PathUtils',
'controllers/ConsumoController'],
	function(ko,ParticipanteRepository,ConsumivelRepository,PathUtils,ConsumoController){

	function ConsumosIndexModel(idEvento){
		var self = this;
		//TODO quebrar em mais classes
		self.idEvento = ko.observable(idEvento);

		self.participantes = ko.observableArray([]);
		self.consumiveis = ko.observableArray([]);

		self.selectedParticipantes = ko.observableArray([]);
		self.selectedConsumiveis = ko.observableArray([]);

		self.novoParticipante = ko.observable();
		self.novoConsumivel = ko.observable();

		self.controller = ko.observable(new ConsumoController(idEvento));
		
		self.novoConsumo = function(){
			if(!self.novoParticipante() || !self.novoConsumivel())
				return;
			self.controller().novoConsumo(self.novoParticipante(),self.novoConsumivel());
			//todo limpar filtro
		}

		//TODO quebrar filtro em outra classe
		self.isFiltered = ko.observable(false);

		self.clearFilter = function(){
			self.isFiltered(false);
			self.selectedConsumiveis([]);
			self.selectedParticipantes([]);
			loadConsumos();
		}

		self.filterConsumiveis = ko.computed(function(){
			if(self.selectedConsumiveis().length == 0)
				return [];

			if(self.selectedConsumiveis().length ==1 && !self.selectedConsumiveis()[0])
				return [];

			var ids = self.selectedConsumiveis().map(function(consumivel){
				return consumivel.id();
			});

			return ['consumiveis=in('+ids.join(',')+')'];

		});

		self.filterParticipantes = ko.computed(function(){
			if(self.selectedParticipantes().length == 0)
				return [];
			if(self.selectedParticipantes().length ==1 && !self.selectedParticipantes()[0])
				return [];

			var ids =  self.selectedParticipantes().map(function(participante){
				return participante.id();
			});
			
			return ['participantes=in('+ids.join(',')+')'];

		});

		self.sortByConsumiveis = function(){
			self.controller().sortConsumos(function(left,right){
				return left.consumivel().compareTo(right.consumivel());
			});

		}

		self.sortByParticipantes = function(){
			self.controller().sortConsumos(function(left,right){
				return left.participante().compareTo(right.participante());
			});
		}

		self.filtrar = function(){
			var filtros = self.filterConsumiveis();
			filtros.push(self.filterParticipantes());
			if(filtros.length <= 0)
				return self.loadConsumos();

			self.controller().loadConsumos(function(consumos){
				self.isFiltered(true);
			}, filtros.join('&'));
		
		}

		function loadConsumos(){
			self.controller().loadConsumos();
		}

		function load(){
			loadConsumos();

			new ParticipanteRepository(self.idEvento()).all({
				callback: function(participantes){
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
	ko.applyBindings(new ConsumosIndexModel(idEvento),document.getElementById('ConsumosModel'));

	$(document).ready(function(){
		$("#filtro").accordion({collapsible:true,active:false});

	});
});