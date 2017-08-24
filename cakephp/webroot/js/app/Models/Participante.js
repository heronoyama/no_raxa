define(['knockout','gateway'],function(ko,Gateway){


	function ParticipanteEdit(data){
		var self=this;
		Participante.call(self,data);

		self.editing = ko.observable(false);
		self.edit = function() { 
			self.editing(true) 
		};

		self.nome.subscribe(function(){
			self.save(function(){
					self.editing(false);
			});
		});

	};

	//TODO extract superclass to remove duplicated code
	function Participante(data){
		var self = this;
		self.idEvento = ko.observable();
		self.id = ko.observable();
		self.nome = ko.observable();
		//Todo trocar para a entidade de fato
		self.consumosData = ko.observableArray();
		self.colaboracoesData = ko.observableArray([]);

		self.compareTo = function(other){
			var nome = self.nome();
			var otherNome = other.nome();
			if(nome == otherNome)
				return 0;
			return (nome < otherNome) ? -1 : 1;
		}

		self.toJson = ko.computed(function(){
			var data = {};
			if(self.id())
				data.id = self.id();
			if(self.idEvento())
				data.eventos_id = self.idEvento();
			data.nome = self.nome()
			return data;
		});

		self.updateData = function(data){
			if(!data)
				return;
			if(data.id)
				self.id(data.id);
			if(data.nome)
				self.nome(data.nome);
			if(data.idEvento)
				self.idEvento(data.idEvento);
			if(data.collaborations){
				var colaboracoes  = data.collaborations.map(function(item){
					return {
						idConsumivel : item.consumables_id,
						valor:item.value,
						id:item.id
					}
				});
				self.colaboracoesData(colaboracoes);
			}
			if(data.consumptions){
				var consumos = data.consumptions.map(function(item){
					return {
						idConsumivel : item.consumables_id,
						id:item.id
					}
				});
				self.consumosData(consumos);
			}
		};

		self.delete = function(callback){
			var gatewayOptions = {
				controller: 'participantes',
				id:self.id(),
				callback : function(result){
					callback(self);
				}
			};
			Gateway.delete(gatewayOptions);
		};

		self.save = function(callback){
			if(self.id()){
				self.update(callback);
				return;
			}
			self.create(callback);
		};

		self.create = function(callback){
			var dateToSave = self.toJson();
			var gatewayOptions = {
				controller: 'participantes',
				data: dateToSave,
				callback : function(result){
					self.updateData(result.participante);
					callback(self);
				}
			};
			Gateway.new(gatewayOptions);
		};

		self.update = function(callback){
			var gatewayOptions = {
				controller: 'participantes',
				id: self.id(),
				data : self.toJson(),
				callback: function(result){
					callback(self);
				}
			};

			Gateway.update(gatewayOptions);
		}

		self.viewUrl = ko.computed(function(){
			return '/eventos/:idEvento/participantes/view/:idParticipante'.replace(":idEvento",self.idEvento()).replace(":idParticipante",self.id());
		});

		self.updateData(data);
	};

	return {
		model : Participante,
		editModel : ParticipanteEdit,
		loadAll: function(options){
			var gatewayOptions = {
				idEvento : options.idEvento,
				controller: 'participantes',
				callback : function(allData){
					var model = options.model ? options.model : Participante;
					var participantes = allData.participantes.map(function(data){ 
						data.idEvento = options.idEvento;
						return new model(data);
					});
                    options.callback(participantes);
				}
			}
			if(options.params)
				gatewayOptions.params = options.params;
			
			Gateway.getAll(gatewayOptions);
		}
	}

});