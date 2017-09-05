define(['knockout',
    'controllers/ConsumoController',
    'repository/ParticipanteRepository',
    'repository/ConsumivelRepository'],
		function(ko,ConsumoController,ParticipanteRepository,ConsumivelRepository){

	 
    function ConsumosForm(options,controller){
        var self = this;
        self.idEvento = ko.observable(options.idEvento);
        self.idParticipante = ko.observable(options.idParticipante);
        self.idConsumivel = ko.observable(options.idConsumivel);
        self.controller = ko.observable(controller);

        self.owner = ko.observableArray([]);
        self.selectedOwner = ko.observable();

        self.novoConsumo = function(){
            var participanteId = self.idParticipante() ? self.idParticipante() : self.selectedOwner().id();
            var consumivelId = self.idConsumivel() ? self.idConsumivel() : self.selectedOwner().id();

            var data = {
					eventos_id : self.idEvento(),
					participantes_id :participanteId,
					consumables_id : consumivelId
            };

            self.controller().novoConsumoData(data);

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
            })
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
        
        self.controller = ko.observable(new ConsumoController(params.idEvento));
        self.consumosForm = ko.observable(new ConsumosForm(params,self.controller()));

        self.isParticipante = ko.observable(params.idParticipante);
        self.idParticipante = ko.observable(params.idParticipante);
        self.idConsumivel = ko.observable(params.idConsumivel);
        
        self.delete = function(consumo){
            self.consumosDataSet().remove(consumo);
        }

        self.getParam = function(){
            if(self.isParticipante())
                return 'participantes=in('+self.idParticipante()+')';
            return 'consumiveis=in('+self.idConsumivel()+')';
        }

        function load(){
            var param = self.getParam();
            self.controller().loadConsumos({params : param});
        }

        load();

        $("#ConsumosComponent").accordion({
                collapsible:true,
				header:'h4',
				heightStyle:'content',
				animate: 200,
				active:false
            });

	}

	function initializeComponente(){
		 ko.components.register('consumos-data-set', {
	        viewModel: Component,
	        template: {require: 'text!templates/ConsumosDataSet.html'}
	    });
	}

	return {
		loadComponent: initializeComponente
            
        
	}

});