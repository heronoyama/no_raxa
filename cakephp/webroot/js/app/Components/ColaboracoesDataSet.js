define(['knockout',
    'models/Colaboracao',
    'models/Participante',
    'models/Consumivel'],
		function(ko,Colaboracao,Participante,Consumivel){

	function ColaboracoesDataSet(options){
        var self = this;
        self.idEvento = ko.observable(options.idEvento);
        self.idParticipante = ko.observable(options.idParticipante);
        self.idConsumivel = ko.observable(options.idConsumivel);
        
        self.colaboracoes = ko.observableArray([]);

        self.param = ko.computed(function(){
            if(self.idParticipante())
                return 'participantes=in('+self.idParticipante()+')';
            return 'consumiveis=in('+self.idConsumivel()+')';
        });

        self.add = function(colaboracao){
            var colaboracoes = self.colaboracoes();
            ko.utils.arrayPushAll(colaboracoes,[colaboracao]);
            self.colaboracoes(colaboracoes);
            self.colaboracoes.valueHasMutated();
        };

        self.remove = function(colaboracaoToDelete){
            colaboracaoToDelete.delete({callback:function(colaboracao){
				self.colaboracoes.remove(colaboracao);
				self.colaboracoes.valueHasMutated();
			}});
        }


        function load(){
            var options = {
                idEvento : self.idEvento(),
                params : self.param(),
                callback : function(colaboracoes){
                    self.colaboracoes(colaboracoes);
                }
            };
            Colaboracao.loadAll(options);
        }

        load();

    };
    
    function ColaboracoesForm(options,dataSet){
        var self = this;
        self.idEvento = ko.observable(options.idEvento);
        self.idParticipante = ko.observable(options.idParticipante);
        self.idConsumivel = ko.observable(options.idConsumivel);
        self.dataSet = ko.observable(dataSet);

        self.owner = ko.observableArray([]);
        self.selectedOwner = ko.observable();

        self.valor = ko.observable();

        self.novaColaboracao = function(){
            var valor = self.valor();
            var participanteId = self.idParticipante() ? self.idParticipante() : self.selectedOwner().id();
            var consumivelId = self.idConsumivel() ? self.idConsumivel() : self.selectedOwner().id();

            var data = {
					eventos_id : self.idEvento(),
					participantes_id :participanteId,
					consumables_id : consumivelId,
					value: valor
            };
            var options = {
                data : data,
                callback: function(colaboracao){
					self.dataSet().add(colaboracao);

				}
            };
            Colaboracao.new(options);

        };

        function load(){
            if(!self.idParticipante()){
                loadParticipantes();
                return
            }
            loadConsumiveis();
        }

        function loadParticipantes(){
            Participante.loadAll({
                idEvento : self.idEvento(),
                callback : function(participantes){
                    self.owner(participantes);
                }
            })
        }

         function loadConsumiveis(){
            Consumivel.loadAll({
                idEvento : self.idEvento(),
                callback : function(consumiveis){
                    self.owner(consumiveis);
                }
            })
        }

        load();

    }

	function Component(params){
		var self = this;
		self.colaboracoesDataSet = ko.observable(new ColaboracoesDataSet(params));
        self.colaboracoesForm = ko.observable(new ColaboracoesForm(params,self.colaboracoesDataSet()));
        self.isParticipante = ko.observable(params.idParticipante);
        
        self.delete = function(colaboracao){
            self.colaboracoesDataSet().remove(colaboracao);
        }

        $("#ColaboracoesComponent").accordion({
                collapsible:true,
				header:'h4',
				heightStyle:'content',
				animate: 200,
				active:false
            });

	}

	function initializeComponente(){
		 ko.components.register('colaboracoes-data-set', {
	        viewModel: Component,
	        template: {require: 'text!templates/ColaboracoesDataSet.html'}
	    });
	}

	return {
		loadComponent: initializeComponente
            
        
	}

});