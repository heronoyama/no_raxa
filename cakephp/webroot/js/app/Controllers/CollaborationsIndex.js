requirejs(['knockout','models/Colaboracao','models/Participante','models/Consumivel','components/PathUtils'],
	function(ko,Colaboracao,Participante,Consumivel,PathUtils){
	

	function CollaborationsIndexModel(idEvento){
		var self = this;
		//TODO quebrar em mais classes
		self.idEvento = ko.observable(idEvento);
		self.colaboracoes =  ko.observableArray([]);
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

			Colaboracao.factory.new({
				data : {
					eventos_id : self.idEvento(),
					participantes_id :self.novoParticipante().id(),
					consumables_id : self.novoConsumivel().id(),
					value: valor
				},
				callback: function(colaboracao){
					if(self.isFiltered()){
						self.clearFilter();
						return;
					}
					
					var found = self.colaboracoes().find(function(each){
						return each.id() == colaboracao.id();
					});
					if(found){
						found.valor(colaboracao.valor());
						return;
					}

					var colaboracoes = self.colaboracoes();
					ko.utils.arrayPushAll(colaboracoes,[colaboracao]);
					self.colaboracoes(colaboracoes);
					self.colaboracoes.valueHasMutated();

				}
			})
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
			var ids = [];
			self.selectedConsumiveis().forEach(function(consumivel){
				ids.push(consumivel.id());
			})
			return ['consumiveis=in('+ids.join(',')+')'];

		});

		self.filterParticipantes = ko.computed(function(){
			if(self.selectedParticipantes().length == 0)
				return [];
			var ids = [];
			self.selectedParticipantes().forEach(function(participante){
				ids.push(participante.id());
			})
			return ['participantes=in('+ids.join(',')+')'];

		});

		self.filtrar = function(){
			var options = {
				idEvento : self.idEvento(),
				callback : function(colaboracoes){
					self.colaboracoes(colaboracoes);
					self.isFiltered(true);
				}
			};

			var filtros = self.filterConsumiveis();
			filtros.push(self.filterParticipantes());
			if(filtros.length > 0)
				options.params = filtros.join('&');

			Colaboracao.factory.loadAll(options);
		
		}

		function loadColaboracoes(){
			Colaboracao.factory.loadAll({
				idEvento : self.idEvento(),
				callback : function(colaboracoes){
					self.colaboracoes(colaboracoes);
				}
			});
		}

		function load(){
			loadColaboracoes();
			Participante.factory.loadAll({
				idEvento : self.idEvento(),
				callback : function(participantes){
					self.participantes(participantes);
				}

			});

			Consumivel.factory.loadAll({
				idEvento : self.idEvento(),
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