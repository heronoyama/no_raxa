define(['knockout',
        'components/PathUtils',
        'gateway',
        'repository/Repository'],
            function(ko,PathUtils,Gateway,Repository){

    function PainelListagem(repository){
        var self = this;
        self.repository = ko.observable(repository);
    }


    //TODO break me plzzz
    function PainelConsumo(idEvento, repository){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        self.repository = ko.observable(repository);

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

        self.getConsumo = function(consumivel){
            if(self.participanteFoco()){
                return self.consumiveisToShow().find(function(each){ return each.idConsumivel == consumivel.id() });
            }
            return self.participantesToShow().find(function(each){ return each.idParticipante == consumivel.id() });
        }

        self.removeConsumivelAoParticipante = function(consumivel){
            var consumo = self.getConsumo(consumivel);
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
                        idConsumivel : consumption.consumable.id,
                        idParticipante : consumption.participante.id
                    }
                    if(self.participanteFoco()){
                        self.atualizaConsumoDoParticipante(consumo);
                    } else {
                        self.atualizaConsumoDoConsumivel(consumo);
                    }
				}
            }
            
            Gateway.new(gatewayOptions);
        }

        self.atualizaConsumoDoParticipante = function(consumo){
            self.participanteFoco().adicionaConsumoData(consumo);
            var consumiveisToShow = self.consumiveisToShow();
            ko.utils.arrayPushAll(consumiveisToShow,[consumo]);
            self.consumiveisToShow(consumiveisToShow);
            self.consumiveisToShow.valueHasMutated();
        }
        self.atualizaConsumoDoConsumivel = function(consumo){
            self.consumoFoco().adicionaConsumoData(consumo);
            var participantesToShow = self.participantesToShow();
            ko.utils.arrayPushAll(participantesToShow,[consumo]);
            self.participantesToShow(participantesToShow);
            self.participantesToShow.valueHasMutated();
        }
    }

    function PainelColaboracao(repository){
        var self = this;
        self.repository = ko.observable(repository);
    }


    function DashboardEntidade(){
        var self = this;
    
        self.idEvento = ko.observable(PathUtils.extractEventoId());
        self.repository = ko.observable(Repository.initalize(self.idEvento(),['Consumptions','Collaborations']));

        self.painelListagem = ko.observable(new PainelListagem(self.repository()));
        self.painelConsumo = ko.observable(new PainelConsumo(self.idEvento(),self.repository()));
        self.painelColaboracao = ko.observable(new PainelColaboracao(self.repository()));

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