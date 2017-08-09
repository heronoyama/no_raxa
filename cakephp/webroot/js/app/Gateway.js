define(['knockout'],function(ko){
	function Gateway(){
		var self = this;
		self.baseUrl = "/api/eventos/:idEvento";

		self.detalhamentoConsumivel = function(options){
			var url = self.baseUrl+'/divisor/detalhamentoConsumivel/:idConsumivel.json';
			url = url.replace(":idEvento",options.idEvento)
					 .replace(":idConsumivel",options.idConsumivel);
			$.getJSON(url,options.callback);
		}

		self.detalhamentoParticipante = function(options){
			var url = self.baseUrl+'/divisor/detalhamentoParticipante/:idParticipante.json';
			url = url.replace(":idEvento",options.idEvento)
					 .replace(":idParticipante",options.idParticipante);
			$.getJSON(url,options.callback);

		}

		self.balancoConsumiveis = function(options){
			var url = self.baseUrl+'/divisor/balancoConsumiveis.json';
			url = url.replace(":idEvento",options.idEvento);
			$.getJSON(url,options.callback);

		}

		self.balancoParticipantes = function(options){
			var url = self.baseUrl+'/divisor/balancoParticipantes.json';
			url = url.replace(":idEvento",options.idEvento);
			$.getJSON(url,options.callback);
		}

		self.update = function(options){
			var url = "/api/:controller/:id.json";
			url = url.replace(":controller",options.controller).replace(":id",options.id);
			$.ajax(url,{
					data : ko.toJSON(options.data),
					type : 'put',
					contentType: 'application/json',
					success: options.callback,
					error: function(result) { 
						console.log(result);
					}
			});
		}

		self.delete = function(options){
			var url = "/api/:controller/:id.json";
			url = url.replace(":controller",options.controller).replace(":id",options.id);
			$.ajax(url,{
					type : 'delete',
					contentType: 'application/json',
					success: options.callback,
					error: function(result) { 
						console.log(result);
					}
			});

		}

		self.getAll = function(options){
			var url = self.baseUrl+"/:controller.json";
			url = url.replace(":controller",options.controller).replace(":idEvento",options.idEvento);
			if(options.params)
			   url +='?'+options.params;
			$.getJSON(url,options.callback);
		}

		self.new = function(options){
			var url = "/api/:controller.json";
			url = url.replace(":controller",options.controller);
			$.ajax(url,{
					data : ko.toJSON(options.data),
					type : 'post',
					contentType: 'application/json',
					success: options.callback,
					error: function(result) { 
						console.log(result);
					}
			});
		}

		self.getEvento = function(options){
			var url = self.baseUrl+".json";
			url = url.replace(":idEvento",options.idEvento);
			$.getJSON(url,options.callback);
		}

		self.updateEvento = function(options){
			var url = self.baseUrl+".json";
			url = url.replace(":idEvento",options.idEvento);
			$.ajax(url, {
                data : ko.toJSON(options.data),
                type : 'put',
                contentType: 'application/json',
                success: options.callback,
                error: function(result) {
                    console.log(result);
                }
            });
		}

	}

	return new Gateway();
});