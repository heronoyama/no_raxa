define(['knockout','gateway','models/Participante'], function(ko,Gateway,Participante){

    function ParticipanteRepository(idEvento){
        var self = this;

        self.idEvento = ko.observable(idEvento);

        self.all = function(options){
            var gatewayOptions = {
                idEvento : self.idEvento(),
                controller: 'participantes',

                callback : function(allData){
                    var model = options.editMode ? Participante.editModel : Participante.model;
					var participantes = allData.participantes.map(function(data){ 
						data.idEvento = self.idEvento();
						return new model(data);
					});
                    options.callback(participantes);
                }
            };

            if(options.params)
                gatewayOptions.params = 'include=('+options.params.join(',')+')';

			Gateway.getAll(gatewayOptions);
        }

        self.novoParticipanteEdit = function(nome,callback){
            self.novoParticipante(nome,true,callback);
        }

        self.novoParticipante = function(nome,editMode,callback){
            var data = {
                eventos_id: self.idEvento(),
                nome: nome
            };
			var gatewayOptions = {
				controller: 'participantes',
				data: data,
				callback : function(result){
                    var model  = editMode? Participante.editModel : Participante.model;
                    var participante = new model(result.participante);
                    callback(participante);
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

        self.delete = function(participanteToDelete,callback){
            var result = confirm("Deseja realmente deletar?");
			if(!result)
                return;
            
            var gatewayOptions = {
				controller: 'participantes',
				id:participanteToDelete.id(),
				callback : function(result){
					callback(participanteToDelete);
				}
			};
            Gateway.delete(gatewayOptions);
        };

    }

    return ParticipanteRepository;
});