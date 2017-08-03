define(['knockout','models/Participante','models/Consumivel'],
		function(ko,Participante,Consumivel){
	
	function Colaboracao(data){
		var self = this;
		self.id = ko.observable(data.id);
		self.valor = ko.observable(data.value);
		self.participante = ko.observable(Participante.factory.create(data.participante));
		self.consumable = ko.observable(Participante.factory.create(data.consumable));


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

                    for(var index in allData.collaborations){
                    	var data = allData.collaborations[index];
                    	colaboracoes.push(new Colaboracao(data));
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
						var colaboracao = new Colaboracao(result.collaboration);
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