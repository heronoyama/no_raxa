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
					alert("deu ruim - token");
					console.log(result);
					console.trace();
					return;
				}
				var token = result.data.token;
				$.ajax({
					url : url,
					type: 'GET',
					dataType : 'json',
					success : callback,
					error : function(result){
						//TODO
						alert("deu call get Json");
						console.log(result);
						console.trace();
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
			self.callGetJson(url,options.callback);
		}

		self.detalhamentoParticipante = function(options){
			var url = self.baseUrl+'/divisor/detalhamentoParticipante/:idParticipante.json';
			url = url.replace(":idEvento",options.idEvento)
					 .replace(":idParticipante",options.idParticipante);
			self.callGetJson(url,options.callback);

		}

		self.balancoConsumiveis = function(options){
			var url = self.baseUrl+'/divisor/balancoConsumiveis.json';
			url = url.replace(":idEvento",options.idEvento);
			self.callGetJson(url,options.callback);

		}

		self.balancoParticipantes = function(options){
			var url = self.baseUrl+'/divisor/balancoParticipantes.json';
			url = url.replace(":idEvento",options.idEvento);
			self.callGetJson(url,options.callback);
		}

		self.update = function(options){
			var url = "/api/:controller/:id.json";
			url = url.replace(":controller",options.controller).replace(":id",options.id);
			var ajaxOpions = {
					data : ko.toJSON(options.data),
					type : 'put',
					contentType: 'application/json',
					success: options.callback,
					error: function(result) { 
						console.log(result);
					}
			};
			self.callCustomAjax(url,ajaxOpions);
		}

		self.delete = function(options){
			var url = "/api/:controller/:id.json";
			url = url.replace(":controller",options.controller).replace(":id",options.id);
			var ajaxOptions = {
					type : 'delete',
					contentType: 'application/json',
					success: options.callback,
					error: function(result) { 
						console.log(result);
					}
			}
			self.callCustomAjax(url,ajaxOptions);

		}

		self.getAll = function(options){
			var url = self.baseUrl+"/:controller.json";
			url = url.replace(":controller",options.controller).replace(":idEvento",options.idEvento);
			if(options.params)
			   url +='?'+options.params;
			self.callGetJson(url,options.callback);
		}

		self.new = function(options){
			var url = "/api/:controller.json";
			url = url.replace(":controller",options.controller);
			var ajaxOptions = {
					data : ko.toJSON(options.data),
					type : 'post',
					contentType: 'application/json',
					success: options.callback,
					error: function(result) { 
						console.log(result);
					}
			}
			self.callCustomAjax(url,ajaxOptions);
		}

		self.getEvento = function(options){
			var url = self.baseUrl+".json";
			url = url.replace(":idEvento",options.idEvento);
			self.callGetJson(url,options.callback);
		}

		self.getSurvey = function(options){
			var url = "/api/survey/questions/"+options.idSurvey+".json";
			self.callGetJson(url,options.callback);
		}

		self.postAnswer = function(options){
			var url = "/api/survey/register/"+options.idSurvey+".json";
			var ajaxOptions = {
					data : options.data,
					type : 'post',
					contentType: 'application/json',
					success: options.callback,
					error: function(result) { 
						console.log(result);
					}
			}
			self.callCustomAjax(url,ajaxOptions);
			
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