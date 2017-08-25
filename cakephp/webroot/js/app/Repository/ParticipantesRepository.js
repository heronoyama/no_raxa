define(['knockout','models/Participante','gateway'],function(ko,Participante,Gateway){

    function ParticipanteEdit(data){
		var self=this;
		Participante.call(self,data);

		self.editing = ko.observable(false);
		self.edit = function() { 
			self.editing(true) 
		};

		self.nome.subscribe(function(){
			self.save(function(){
					self.editing(false);
			});
		});

	};

    function ParticipanteRepository(options){
        var self = this;
        self.idEvento = ko.observable(options.idEvento);
        self.editMode = options.editMode;
        self.params = options.params;
        self.participantes = ko.observableArray([]);

        self.nomeParticipante = ko.observable();

        self.getModel = function(){
            return self.editMode ? ParticipanteEdit : Participante;
        }

        self.novo = function(data,callback){

			var gatewayOptions = {
				controller: 'participantes',
				data: data,
				callback : function(result){
                    var model  = self.getModel();
                    var participante = new model(result.participante);
                    var participantes = self.participantes();

                    ko.utils.arrayPushAll(participantes,[participante]);
                    self.participantes(participantes);
                    self.participantes.valueHasMutated();
					callback(self);
				}
            };
            
			Gateway.new(gatewayOptions);
        }

        self.update = function(participante,callback){
            var gatewayOptions = {
				controller: 'participantes',
				id: participante.id(),
				data : participante.toJson(),
				callback: function(result){
					callback(participante);
				}
			};

			Gateway.update(gatewayOptions);
        }

        self.delete = function(participanteToDelete){
            var result = confirm("Deseja realmente deletar?");
			if(!result)
				return;
            participanteToDelete.delete(function(participante){
                    self.participantes.remove(participante);
                    self.participantes.valueHasMutated();
                });
        };


        function load(options){
            var gatewayOptions = {
                idEvento : self.idEvento(),
                controller: 'participantes',

                callback : function(participantes){
                    var model = self.editMode ? ParticipanteEdit : Participante;
					var participantes = allData.participantes.map(function(data){ 
						data.idEvento = options.idEvento;
						return new model(data);
					});
                    self.participantes(participantes);
                    if(options.callback)
                        options.callback(participantes);
                }
            };

            if(self.params)
                gatewayOptions.params = 'include=('+self.params.join(',')+')';

			Gateway.getAll(gatewayOptions);
        }

        load(options);

    }

    return {
        initialize : function(options){
            return new ParticipanteRepository(options);
        }
    }

});