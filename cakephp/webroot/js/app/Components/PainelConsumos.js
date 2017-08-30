define(['knockout'],function(ko){

    function PainelConsumo(idEvento, repository){
        var self = this;
        
        self.idEvento = ko.observable(idEvento);
        self.repository = ko.observable(repository);

        self.participanteFoco = ko.observable();
        self.consumivelFoco = ko.observable();
        self.consumosSelecionados = ko.observableArray([]);

        self.participanteSelecionado = function(participante){
            self.participanteFoco(participante);
            self.consumivelFoco(null);
            self.consumosSelecionados([]);
            self.consumosSelecionados(self.repository().consumoRepository().consumosDoParticipante(participante));
        }

        self.consumivelSelecionado = function(consumivel){
            self.consumivelFoco(consumivel);
            self.participanteFoco(null);
            self.consumosSelecionados([]);
            self.consumosSelecionados(self.repository().consumoRepository().consumosDoConsumivel(consumivel));
        }

        self.consumoDoParticipante = function(participante){
            return self.consumosSelecionados().find(function(consumo){ return consumo.participante().id() == participante.id();});
        }

        self.consumoDoConsumivel = function(consumivel){
            return self.consumosSelecionados().find(function(consumo){ return consumo.consumable().id() == consumivel.id();});
        }

        self.getCssParticipante = function(participante){
            if(self.participanteFoco())
                return self.participanteFoco() == participante ? "active" : '';
            return  self.consumoDoParticipante(participante) ? 'marked' : '';
        }

        self.getCssConsumivel = function(consumivel){
            if(self.consumivelFoco())
                return self.consumivelFoco() == consumivel ? "active" : '';

            return self.consumoDoConsumivel(consumivel) ? 'marked':'';
        }

        self.isParticipanteActive = function(participante){
            if(self.participanteFoco())
                return self.participanteFoco() == participante;

            return self.consumoDoParticipante(participante);
        };

        self.isConsumivelActive = function(consumivel){
            if(self.consumivelFoco())
                return self.consumivelFoco() == consumivel;
            return self.consumoDoConsumivel(consumivel);
        }

        self.findConsumo = function(participante,consumivel){
            return self.consumosSelecionados().find(function(consumo){ 
                return consumo.participante().id() == participante.id() && consumo.consumable().id() == consumivel.id();
            });
        }

        self.getConsumo = function(entidade){
            var participante = self.participanteFoco() ? self.participanteFoco() : entidade;
            var consumivel = self.consumivelFoco()? self.consumivelFoco() : entidade;
            return self.findConsumo(participante,consumivel);
            ///TODO trocar para OWNER  e flag para participante x consumivel
        }

        self.removeConsumivelAoParticipante = function(entidade){
            var consumo = self.getConsumo(entidade);

            self.repository().consumoRepository().delete(consumo,function(){
                self.consumosSelecionados.remove(consumo);
                self.consumosSelecionados.valueHasMutated();
            });
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

            self.repository().consumoRepository().novo(data,
                function(consumo){
                    var consumos = self.consumosSelecionados();
                    ko.utils.arrayPushAll(consumos,[consumo]);
                    self.consumosSelecionados(consumos);
                    self.consumosSelecionados.valueHasMutated();
                });
           
        }

    }

    return PainelConsumo;
});