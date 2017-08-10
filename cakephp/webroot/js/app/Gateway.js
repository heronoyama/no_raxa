define(['knockout'],function(ko){
	function Gateway(){
		var self = this;
		self.baseUrl = "/api/eventos/:idEvento";

		self.getToken = function(callback){
			var url = "/api/users/token.json";
			$.getJSON(url,function(result){
					callback(result);
				}
			);
		};

		self.callGetJson = function(url,callback){
			self.getToken(function(result){
				if(!result.success){
					alert("deu ruim");
					console.log(result);
					return;
				}
				var token = result.data.token;
				$.ajax({
					url : url,
					type: 'GET',
					dataType : 'application/json',
					success : callback,
					error : function(reuslt){
						//TODO
						alert("deu ruim");
						console.log(result);
					},
					beforeSend : function(xhr){
						xhr.setRequestHeader('Authorization','Bearer '+token);
					}
				});
			});
		}

		self.callCustomAjax = function(url,options){
			self.getToken(function(result){
				if(!result.success){
					alert("deu ruim");
					console.log(result);
					return;
				}
				var token = result.data.token;
				options.beforeSend = function(xhr){
						xhr.setRequestHeader('Authorization','Bearer '+token);
					};
				$.ajax(url,options);

			});
		}

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
			var ajaxOptions = {
                data : ko.toJSON(options.data),
                type : 'put',
                contentType: 'application/json',
                success: options.callback,
                error: function(result) {
                    console.log(result);
				}
			}
				
			self.callCustomAjax(url,ajaxOptions);
		}

	}

	return new Gateway();
});