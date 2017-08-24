define(['knockout','gateway'],function(ko,Gateway){

	function ConsumivelEdit(data){
		var self = this;
		Consumivel.call(self,data);

		self.editing = ko.observable(false);

		self.edit = function() { 
			self.editing(true) 
		};

		self.nome.subscribe(function(){
			self.save(function(){
					self.editing(false);
				}
			);
		});
	};
	
	function Consumivel(data){
		var self = this;
		self.idEvento = ko.observable();
		self.id = ko.observable();
		self.nome = ko.observable();

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
		};

		self.delete = function(callback){
			var gatewayOptions = {
				controller: 'consumables',
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
				controller: 'consumables',
				data: dateToSave,
				callback : function(result){
					self.updateData(result.consumable);
					callback(self);
				}
			};
			Gateway.new(gatewayOptions);
		};

		self.update = function(callback){
			var gatewayOptions = {
				controller: 'consumables',
				id: self.id(),
				data : self.toJson(),
				callback: function(result){
					callback(self);
				}
			};

			Gateway.update(gatewayOptions);
		}

		self.viewUrl = ko.computed(function(){
			return '/eventos/:idEvento/consumables/view/:idConsumivel'.replace(":idEvento",self.idEvento()).replace(":idConsumivel",self.id());
		});

		self.updateData(data);
	};

	return {
		model : Consumivel,
		editModel: ConsumivelEdit,
		loadAll : function(options){
			var gatewayOptions = {
				idEvento : options.idEvento,
				controller: 'consumables',
				callback : function(allData){
					var model = options.model ? options.model : Consumivel;
					var consumiveis = allData.consumables.map(function(data){
						data.idEvento = options.idEvento;
						return new model(data);
					});
                    options.callback(consumiveis);
				}
			}
			if(options.param)
				gatewayOptions.param = options.param;
			
			Gateway.getAll(gatewayOptions);
		}
	}


});