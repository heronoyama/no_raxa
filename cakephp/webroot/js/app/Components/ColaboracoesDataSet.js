define(['knockout',
    'controllers/ColaboracaoController',
    'repository/ParticipanteRepository',
    'repository/ConsumivelRepository'],
		function(ko,ColaboracaoController,ParticipanteRepository,ConsumivelRepository){

	
    function ColaboracoesForm(options,controller){
        var self = this;
        self.idEvento = ko.observable(options.idEvento);
        self.idParticipante = ko.observable(options.idParticipante);
        self.idConsumivel = ko.observable(options.idConsumivel);
        self.controller = ko.observable(controller);

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

            self.controlle().novaColaboracaoData(data);

        };

        function load(){
            if(!self.idParticipante()){
                loadParticipantes();
                return
            }
            loadConsumiveis();
        }

        function loadParticipantes(){
            new ParticipanteRepository(self.idEvento()).all({
                callback : function(participantes){
                    self.owner(participantes);
                }
            });
        }

         function loadConsumiveis(){
            new ConsumivelRepository(self.idEvento()).all({
                callback : function(consumiveis){
                    self.owner(consumiveis);
                }
            });
        }

        load();

    }

	function Component(params){
        var self = this;
        
		self.controller = ko.observable(new ColaboracaoController(params.idEvento));
        self.colaboracoesForm = ko.observable(new ColaboracoesForm(params,self.controller()));
        self.isParticipante = ko.observable(params.idParticipante);
        self.idParticipante = ko.observable(params.idParticipante);
        self.idConsumivel = ko.observable(params.idConsumivel);
        
        self.delete = function(colaboracao){
            self.colaboracoesDataSet().remove(colaboracao);
        }

        self.getParam = function(){
            if(self.isParticipante())
                return 'participantes=in('+self.idParticipante()+')';
            return 'consumiveis=in('+self.idConsumivel()+')';
        }

        function load(){
            var param = self.getParam();
            self.controller().loadColaboracoes({params : param});
        }

        load();

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