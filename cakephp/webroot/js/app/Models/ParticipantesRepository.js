define(['knockout','models/Participante','gateway'],function(ko,Participante,Gateway){

    function ParticipanteRepository(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        self.participantes = ko.observableArray([]);

        self.nomeParticipante = ko.observable();

        self.criaParticipante = function(){
            var participante = new Participante.editModel({
			    nome : self.nomeParticipante(), 
			    idEvento:self.idEvento()
		    });

		    participante.save(
				function(participante){
                    var participantes = self.participantes();
                    ko.utils.arrayPushAll(participantes,[participante]);
                    self.participantes(participantes);
					self.participantes.valueHasMutated();
					self.nomeParticipante(null);
                }
            );
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


        function load(){
            var options = {
                idEvento : self.idEvento(),
                model : Participante.editModel,
                callback : function(participantes){
                    self.participantes(participantes);
                }
            };

		    Participante.loadAll(options);
        }

        load();

    }

    return ParticipanteRepository;


});