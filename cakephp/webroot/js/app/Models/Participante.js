define(['knockout'],function(ko){

	//TODO extract superclass to remove duplicated code
	function Participante(data){
		var self = this;
		self.idEvento = ko.observable();
		self.id = ko.observable();
		self.nome = ko.observable();

		//Todo trocar para a entidade de fato
		self.consumosData = ko.observableArray();
		self.colaboracoesData = ko.observableArray([]);

		self.editing = ko.observable(false);
		self.edit = function() { 
			self.editing(true) 
		};

		self.subscribeNome = function(subscribeCallback){
			self.nome.subscribe(function(){
				subscribeCallback(self,function(){
					self.editing(false);
				});
			});
		}

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

		self.viewUrl = ko.computed(function(){
			return '/eventos/:idEvento/participantes/view/:idParticipante'.replace(":idEvento",self.idEvento()).replace(":idParticipante",self.id());
		});

		self.updateData(data);
	};

	return Participante;

});