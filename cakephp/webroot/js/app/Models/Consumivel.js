define(['knockout'],function(ko){
	
	function Consumivel(data){
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

		self.save = function(options){
			var dateToSave = self.toJson();
			
			if(!dateToSave.id){
				dateToSave.eventos_id = options.evento_id;
			}
			
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
					options.callback(self)

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
			var url = '/api/eventos/' + options.idEvento + '/consumables.json';
            $.getJSON(url,
                function(allData){
                    var consumables = [];

                    for(var index in allData.consumables){
                    	var data = allData.consumables[index];
                    	consumables.push(new Consumivel(data));
                    }
                    
                    options.callback(consumables);
            });

		}
		self.create = function(data){
			return new Consumivel(data);
		}

	}

	return {
		model : Consumivel,
		factory: new Factory()
	}


});