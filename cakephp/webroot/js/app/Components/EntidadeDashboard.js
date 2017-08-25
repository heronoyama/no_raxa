define(['knockout',
        'components/PathUtils',
        'gateway',
        'models/ParticipantesRepository',
        'models/ConsumivelRepository'],
            function(ko,PathUtils,Gateway,ParticipantesRepository,ConsumivelRepository){

    function PainelListagem(participanteRepository,consumivelRepository){
        var self = this;
        self.participanteRepository = ko.observable(participanteRepository);
        self.consumivelRepository = ko.observable(consumivelRepository);
    }

    function PainelConsumo(idEvento, participanteRepository,consumivelRepository){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        self.participanteRepository = ko.observable(participanteRepository);
        self.consumivelRepository = ko.observable(consumivelRepository);

        self.participanteFoco = ko.observable();
        self.consumiveisToShow = ko.observableArray([]);

        self.consumivelFoco = ko.observable();
        self.participantesToShow = ko.observableArray([]);

        self.participanteSelecionado = function(participante){
            self.participanteFoco(participante);
            self.consumiveisToShow(participante.consumosData());
            self.consumivelFoco(null);
            self.participantesToShow([]);
        }

        self.consumivelSelecionado = function(consumivel){
            self.consumivelFoco(consumivel);
            self.participantesToShow(consumivel.consumosData());
            self.participanteFoco(null);
            self.consumiveisToShow([]);
        }

        self.getCssParticipante = function(participante){
            if(self.participanteFoco())
                return self.participanteFoco() == participante ? "active" : '';

            return self.participantesMarkedId().indexOf(participante.id()) >=0 ? 'marked' :'';
        }

        self.getCssConsumivel = function(consumivel){
            if(self.consumivelFoco())
                return self.consumivelFoco() == consumivel ? "active" : '';

            return self.consumiveisMarkedId().indexOf(consumivel.id()) >=0 ? 'marked' :'';
        }

        self.isParticipanteActive = function(participante){
            if(self.participanteFoco())
                return self.participanteFoco() == participante;
            return self.participantesMarkedId().indexOf(participante.id()) >=0;
        };

        self.isConsumivelActive = function(consumivel){
            if(self.consumivelFoco())
                return self.consumivelFoco() == consumivel;
            return self.consumiveisMarkedId().indexOf(consumivel.id()) >=0;
        }

        self.consumivelIsSelected = function(consumivel){
            return self.consumivelFoco() == participante();
        }

        self.consumiveisMarkedId = ko.computed(function(){
            return self.consumiveisToShow().map(function(each){ return each.idConsumivel; });
        });

        self.participantesMarkedId = ko.computed(function(){
            return self.participantesToShow().map(function(each){ return each.idParticipante; });
        });

        self.getConsumo = function(){
            var lista = self.participanteFoco()? self.consumiveisToShow() : self.participantesToShow();
            return lista.find(function(each){ return each.idConsumivel == consumivel.id() });
        }

        self.removeConsumivelAoParticipante = function(consumivel){
            var consumo = self.getConsumo();
            var gatewayOptions = {
				controller: 'consumptions',
				id:consumo.id,
				callback : function(result){
                    self.consumiveisToShow.remove(consumo);
                    self.consumiveisToShow.valueHasMutated();
				}
            };
            
			Gateway.delete(gatewayOptions);
        }

        self.adicionaConsumivelAoParticipante = function(entidade){
            var data = {
                    eventos_id : self.idEvento(),
            };
            if(self.participanteFoco()){
                data.participantes_id = self.participanteFoco().id();
                data.consumables_id = entidade.id();
            } else {
                data.participantes_id = entidade.id();
                data.consumables_id = self.consumivelFoco().id();
            }

            var gatewayOptions = {
				controller: 'consumptions',
				data: data,
				callback : function(result){
                    var consumption = result.consumption;
					var consumo = {
                        id : consumption.id,
                        idConsumivel : consumption.consumable.id
                    }
                    var consumiveisToShow = self.consumiveisToShow();
                    ko.utils.arrayPushAll(consumiveisToShow,[consumo]);
                    self.consumiveisToShow(consumiveisToShow);
                    self.consumiveisToShow.valueHasMutated();
				}
            }
            
            Gateway.new(gatewayOptions);
        }
    }

    function PainelColaboracao(participanteRepository,consumivelRepository){
        var self = this;
        self.participanteRepository = ko.observable(participanteRepository);
        self.consumivelRepository = ko.observable(consumivelRepository);
    }


    function DashboardEntidade(){
        var self = this;
    
        self.idEvento = ko.observable(PathUtils.extractEventoId());
        self.participanteRepository = ko.observable(new ParticipantesRepository(self.idEvento()));
        self.consumivelRepository = ko.observable(new ConsumivelRepository(self.idEvento()));

        self.painelListagem = ko.observable(new PainelListagem(self.participanteRepository(),self.consumivelRepository()));
        self.painelConsumo = ko.observable(new PainelConsumo(self.idEvento(),self.participanteRepository(),self.consumivelRepository()));
        self.painelColaboracao = ko.observable(new PainelColaboracao(self.participanteRepository(),self.consumivelRepository()));

        self.modoListagem = ko.observable(true);
        self.modoConsumo = ko.observable(false);
        self.modoColaboracao = ko.observable(false);

        self.setModoListagem = function(){
            self.modoListagem(true);
            self.modoConsumo(false);
            self.modoColaboracao(false);
        }

        self.setModoConsumo = function(){
            self.modoListagem(false);
            self.modoConsumo(true);
            self.modoColaboracao(false);
        }

        self.setModoColaboracao = function(){
            self.modoListagem(false);
            self.modoConsumo(false);
            self.modoColaboracao(true);
        }

    }

    function initializeComponente(){
		 ko.components.register('dashboard-entidade', {
	        viewModel: DashboardEntidade,
	        template: {require: 'text!templates/DashboardEntidade.html'}
	    });
    }
    
    return {
		loadComponent: initializeComponente
	}

});