define(['knockout'],function(ko){
	return function Participante(data){
		var self = this;
		self.id = ko.observable();
		self.nome = ko.observable();


		self.updateData = function(data){
			if(data.id)
				self.id(data.id);
			if(data.nome)
				self.nome(data.nome);			
		};

		self.deletar = function(callback){
			$.ajax('/api/participantes/'+self.id()+'.json',{
				type : 'delete',
				contentType: 'application/json',
				success: function(result) { 
					alert("Participante deletado com sucesso!");
					callback();
				},
				error: function(result) { 
					console.log(result);
				}
			});
		};

		self.update = function(data,callback){
			self.updateData(data);
			var dataToUpdate = ko.toJSON({
				nome : self.nome()
			});
			$.ajax('/api/participantes/'+self.id()+'.json', {
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