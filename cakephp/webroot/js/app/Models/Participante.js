define(['knockout'],function(ko){

	//TODO extract superclass to remove duplicated code
	function Participante(data){
		var self = this;
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
		};

		self.deletar = function(callback){
			$.ajax('/api/participantes/'+self.id()+'.json',{
				type : 'delete',
				contentType: 'application/json',
				success: function(result) { 
					alert("Participante deletado com sucesso!");
					callback(self);
				},
				error: function(result) { 
					console.log(result);
				}
			});
		};

		self.save = function(options){
			var dateToSave = self.toJson();
			if(!dateToSave.id){
				dateToSave.eventos_id = options.evento_id;
			}
			var method = dateToSave.id ? 'put' : 'post';
			var url = dateToSave.id ? 
				'/api/participantes/'+dateToSave.id+'.json' : 
				'/api/participantes.json';

			$.ajax(url, {
					data : ko.toJSON(dateToSave),
					type : method,
					contentType: 'application/json',
					success: function(result) { 
						if(!dateToSave.id)
						self.id(result.participante.id);
						options.callback(self);
					},
					error: function(result) { 
						console.log(result);
					}
			});
		};

		self.updateData(data);
	};

	function Factory(){
		var self = this;
		self.loadAll = function(options){
			var url = '/api/eventos/' + options.idEvento + '/participantes.json';
            $.getJSON(url,
                function(allData){
                    var participantes = [];

                    for(var index in allData.participantes){
                    	var data = allData.participantes[index];
                    	participantes.push(new Participante(data));
                    }
                    
                    options.callback(participantes);
            });
		},
		self.create = function(data){
			return new Participante(data);
		}
	}

	return {
		model : Participante,
		factory : new Factory()
	}

});