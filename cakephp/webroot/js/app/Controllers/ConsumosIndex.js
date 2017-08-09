requirejs(['knockout','models/Consumo','models/Participante','models/Consumivel','components/PathUtils'],
	function(ko,Consumo,Participante,Consumivel,PathUtils){

	function ConsumoEdit(data){
		var self = this;
		Consumo.model.call(self,data);
		self.editing = ko.observable(false);
		self.edit = function(){
			self.editing(true);
		}

	}	

	function ConsumosIndexModel(idEvento){
		var self = this;
		//TODO quebrar em mais classes
		self.idEvento = ko.observable(idEvento);
		self.consumos =  ko.observableArray([]);
		self.participantes = ko.observableArray([]);
		self.consumiveis = ko.observableArray([]);

		self.selectedParticipantes = ko.observableArray([]);
		self.selectedConsumiveis = ko.observableArray([]);

		self.novoParticipante = ko.observable();
		self.novoConsumivel = ko.observable();
		
		self.delete = function(consumoToDelete){
			consumoToDelete.delete(function(consumo){
				self.consumos.remove(consumo);
				self.consumos.valueHasMutated();
			});

		}

		self.novoConsumo = function(){
			if(!self.novoParticipante() || !self.novoConsumivel())
				return;
			

			Consumo.factory.new({
				data : {
					eventos_id : self.idEvento(),
					participantes_id :self.novoParticipante().id(),
					consumables_id : self.novoConsumivel().id()
				},
				model : ConsumoEdit,
				callback: function(consumo){
					if(self.isFiltered()){
						self.clearFilter();
						return;
					}

					var consumos = self.consumos();
					ko.utils.arrayPushAll(consumos,[consumo]);
					self.consumos(consumos);
					self.consumos.valueHasMutated();

				}
			})
		}

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
			self.consumos.sort(function(left,right){
				return left.consumable().compareTo(right.consumable());
			});
		}

		self.sortByParticipantes = function(){
			self.consumos.sort(function(left,right){
				return left.participante().compareTo(right.participante());
			});
		}

		self.filtrar = function(){
			var options = {
				model : ConsumoEdit,
				idEvento : self.idEvento(),
				callback : function(consumos){
					self.consumos(consumos);
					self.isFiltered(true);
				}
			};

			var filtros = self.filterConsumiveis();
			filtros.push(self.filterParticipantes());
			if(filtros.length > 0)
				options.params = filtros.join('&');

			Consumo.factory.loadAll(options);
		
		}

		function loadConsumos(){
			Consumo.factory.loadAll({
				idEvento : self.idEvento(),
				model : ConsumoEdit,
				callback : function(consumos){
					self.consumos(consumos);
				}
			});
		}

		function load(){
			loadConsumos();
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
	ko.applyBindings(new ConsumosIndexModel(idEvento),document.getElementById('ConsumosModel'));

	$(document).ready(function(){
		$("#filtro").accordion({collapsible:true,active:false});

	});
});