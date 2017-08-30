define(['knockout','repository/ParticipanteRepository'],function(ko,ParticipanteRepository){

    function ParticipanteController(idEvento){
        var self = this;

    	self.idEvento = ko.observable(idEvento);

	    self.participantes = ko.observableArray([]);
	    self.nomeParticipante =  ko.observable();
	    self.repository = ko.observable();

	    self.criaParticipante = function(){
		    self.repository().novoParticipanteEdit(self.nomeParticipante(),function(participante){
                var participantes = self.participantes();
                ko.utils.arrayPushAll(participantes,[participante]);
                self.participantes(participantes);
                self.participantes.valueHasMutated();
                self.nomeParticipante(null);
    		});
	    };

        self.delete = function(participanteToDelete){
            self.repository().delete(participanteToDelete,function(participante){
                self.participantes.remove(participante);
                self.participantes.valueHasMutated();
            });
        };

        function load(){
            self.repository(new ParticipanteRepository(self.idEvento()));
            self.repository().all({
                editMode : true,
                callback: function(participantes){
                    self.participantes(participantes);
                }
            });
        }

	    load();
    }

    return ParticipanteController;

});