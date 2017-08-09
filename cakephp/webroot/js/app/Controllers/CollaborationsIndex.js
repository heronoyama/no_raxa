requirejs(['knockout','models/Colaboracao','models/Participante','models/Consumivel','components/PathUtils'],
	function(ko,Colaboracao,Participante,Consumivel,PathUtils){

	function ColaboracaoEdit(data){
		var self = this;
		Colaboracao.model.call(self,data);
		self.editing = ko.observable(false);
		self.edit = function(){
			self.editing(true);
		}

		self.valor.subscribe(function() {
            self.updateValue({
            	callback: function(){
            		alert("Colaboração atualizada com sucesso!");
                	self.editing(false);
    	    	}
    		});
        });
	}	

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

		self.delete = function(colaboracaoToDelete){
			colaboracaoToDelete.delete({callback:function(colaboracao){
				self.colaboracoes.remove(colaboracao);
				self.colaboracoes.valueHasMutated();
			}});

		}

		self.novaColaboracao = function(){
			if(!self.novoParticipante() || !self.novoConsumivel())
				return;
			var valor = self.novoValor()? self.novoValor() : 0;

			Colaboracao.new({
				data : {
					eventos_id : self.idEvento(),
					participantes_id :self.novoParticipante().id(),
					consumables_id : self.novoConsumivel().id(),
					value: valor
				},
				model : ColaboracaoEdit,
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

		self.sortByConsumiveis = function(){
			self.colaboracoes.sort(function(left,right){
				return left.consumable().compareTo(right.consumable());
			});
		}

		self.sortByParticipantes = function(){
			self.colaboracoes.sort(function(left,right){
				return left.participante().compareTo(right.participante());
			});
		}

		self.sortByValores = function(){
			self.colaboracoes.sort(function(left,right){
				return left.compareTo(right);
			});	
		}

		self.filtrar = function(){
			var options = {
				model : ColaboracaoEdit,
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

			Colaboracao.loadAll(options);
		
		}

		function loadColaboracoes(){
			Colaboracao.loadAll({
				idEvento : self.idEvento(),
				model : ColaboracaoEdit,
				callback : function(colaboracoes){
					self.colaboracoes(colaboracoes);
				}
			});
		}

		function load(){
			loadColaboracoes();
			Participante.loadAll({
				idEvento : self.idEvento(),
				callback : function(participantes){
					self.participantes(participantes);
				}

			});

			Consumivel.loadAll({
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