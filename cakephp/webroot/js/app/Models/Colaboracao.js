define(['knockout','models/Participante','models/Consumivel'],
		function(ko,Participante,Consumivel){
	
	function Colaboracao(data){
		var self = this;
		self.id = ko.observable(data.id);
		self.valor = ko.observable(parseInt(data.value));
		self.participante = ko.observable(Participante.factory.create(data.participante));
		self.consumable = ko.observable(Participante.factory.create(data.consumable));

		self.compareTo = function(other){
			var valor = self.valor();
			var otherValor = other.valor();
			if(valor == otherValor){
				var comparisonParticipante = self.participante().compareTo(other.participante());
				if(comparisonParticipante == 0)
					return comparisonParticipante;
				return self.consumable().compareTo(other.consumable());
			}
			return (valor < otherValor) ? -1 : 1;
		}

		self.toJson = ko.computed(function(){
			return {
					id : self.id(),
					paritcipantes_id : self.participante().id(),
					consumableS_id : self.consumable().id(),
					value : parseInt(self.valor())
					}
		});

		self.updateValue = function(options){
			var url = '/api/collaborations/'+self.id()+'.json';
			$.ajax(url,{
					data : ko.toJSON(self.toJson()),
					type : 'put',
					contentType: 'application/json',
					success: function(result) { 
						options.callback(self);
					},
					error: function(result) { 
						console.log(result);
					}
			});
		}

		self.delete = function(options){
			var url = '/api/collaborations/'+self.id()+'.json';
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
			var url = '/api/eventos/' + options.idEvento + '/collaborations.json';
            if(options.params)
               url +='?'+options.params;
            $.getJSON(url,
                function(allData){
                    var colaboracoes = [];
                    var model = options.model ? options.model : Colaboracao;
                    for(var index in allData.collaborations){
                    	var data = allData.collaborations[index];
                    	colaboracoes.push(new model(data));
                    }
                    
                    options.callback(colaboracoes);
            });
		}
		self.new = function(options){
			var data = ko.toJSON(options.data);
			var url = '/api/collaborations.json';
			$.ajax(url,{
					data : data,
					type : 'post',
					contentType: 'application/json',
					success: function(result) { 
						var model = options.model ? options.model : Colaboracao;
						var colaboracao = new model(result.collaboration);
						options.callback(colaboracao);
					},
					error: function(result) { 
						console.log(result);
					}
			});
		}
		
	}

	return {
		model : Colaboracao,
		factory : new Factory()
		}
});