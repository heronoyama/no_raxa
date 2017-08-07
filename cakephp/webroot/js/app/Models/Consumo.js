define(['knockout','models/Participante','models/Consumivel'],
		function(ko,Participante,Consumivel){
	
	function Consumo(data){
		var self = this;
		self.id = ko.observable(data.id);
		self.participante = ko.observable(Participante.factory.create(data.participante));
		self.consumable = ko.observable(Participante.factory.create(data.consumable));

		self.compareTo = function(other){
			var comparisonParticipante = self.participante().compareTo(other.participante());
			if(comparisonParticipante == 0)
				return comparisonParticipante;
			return self.consumable().compareTo(other.consumable());
			
		}

		self.toJson = ko.computed(function(){
			return {
					id : self.id(),
					paritcipantes_id : self.participante().id(),
					consumableS_id : self.consumable().id()
					}
		});

		// self.updateValue = function(options){
		// 	var url = '/api/collaborations/'+self.id()+'.json';
		// 	$.ajax(url,{
		// 			data : ko.toJSON(self.toJson()),
		// 			type : 'put',
		// 			contentType: 'application/json',
		// 			success: function(result) { 
		// 				options.callback(self);
		// 			},
		// 			error: function(result) { 
		// 				console.log(result);
		// 			}
		// 	});
		// }

		self.delete = function(options){
			var url = '/api/consumptions/'+self.id()+'.json';
			$.ajax(url,{
				type : 'delete',
				contentType: 'application/json',
					success: function(result) { 
						options.callback(self);
					},
					error: function(result) { 
						alert("check console for errors");
						console.log(result);
					}
			});
		}
	}

	function Factory(){
		var self = this;
		self.loadAll = function(options){
			var url = '/api/eventos/' + options.idEvento + '/consumptions.json';
            if(options.params)
               url +='?'+options.params;
            $.getJSON(url,
                function(allData){
                    var consumos = [];
                    var model = options.model ? options.model : Consumo;
                    for(var index in allData.consumptions){
                    	var data = allData.consumptions[index];
                    	consumos.push(new model(data));
                    }
                    
                    options.callback(consumos);
            });
		}
		self.new = function(options){
			var data = ko.toJSON(options.data);
			var url = '/api/consumptions.json';
			$.ajax(url,{
					data : data,
					type : 'post',
					contentType: 'application/json',
					success: function(result) { 
						var model = options.model ? options.model : Consumo;
						var consumo = new model(result.consumption);
						options.callback(consumo);
					},
					error: function(result) { 
						alert(result.responseJSON.message);
					}
			});
		}
		
	}

	return {
		model : Consumo,
		factory : new Factory()
		}
});