define(['knockout'],function(ko){
	return function Consumivel(data){
		var self = this;
		self.id = ko.observable();
		self.nome = ko.observable();


		self.updateData = function(data){
			if(!data)
				return;
			if(data.id)
				self.id(data.id);
			if(data.nome)
				self.nome(data.nome);			
		};

		self.deletar = function(callback){
			$.ajax('/api/consumables/'+self.id()+'.json',{
				type : 'delete',
				contentType: 'application/json',
				success: function(result) { 
					alert("Consumível deletado com sucesso!");
					callback(self);
				},
				error: function(result) { 
					console.log(result);
				}
			});
		};

		self.toJson = ko.computed(function(){
			var data = {};
			if(self.id())
				data.id = self.id();
			data.nome = self.nome()
			return data;
		});

		self.save = function(eventoID,callback){
			var dateToSave = self.toJson();
			dateToSave.eventos_id = eventoID;
			var method = dateToSave.id ? 'put' : 'post';
			var url = dateToSave.id ? 
				'/api/consumables/'+dateToSave.id+'.json' : 
				'/api/consumables.json';

			$.ajax(url, {
				data : ko.toJSON(dateToSave),
				type : method,
				contentType: 'application/json',
				success: function(result) { 
					if(!dateToSave.id)
						self.id(result.consumable.id);
					callback(self)

				},
				error: function(result) { 
					console.log(result);
				}
			});
		};


		self.update = function(data,callback){
			var dataToUpdate = ko.toJSON({
				nome : self.nome()
			});
			$.ajax('/api/consumables/'+self.id()+'.json', {
					data : dataToUpdate,
					type : 'put',
					contentType: 'application/json',
					success: function(result) { 
						alert("nome atualizado com sucesso!");
						callback();
					},
					error: function(result) { 
						console.log(result);
					}
			});
		};

		self.updateData(data);
	};


});