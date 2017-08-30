define(['knockout',
    'models/Consumo',
    'repository/ParticipanteRepository',
    'models/Consumivel'],
		function(ko,Consumo,ParticipanteRepository,Consumivel){

	function ConsumosDataSet(options){
        var self = this;
        self.idEvento = ko.observable(options.idEvento);
        self.idParticipante = ko.observable(options.idParticipante);
        self.idConsumivel = ko.observable(options.idConsumivel);
        
        self.consumos = ko.observableArray([]);

        self.param = ko.computed(function(){
            if(self.idParticipante())
                return 'participantes=in('+self.idParticipante()+')';
            return 'consumiveis=in('+self.idConsumivel()+')';
        });

        self.add = function(consumo){
            var consumos = self.consumos();
            ko.utils.arrayPushAll(consumos,[consumo]);
            self.consumos(consumos);
            self.consumos.valueHasMutated();
        };

        self.remove = function(consumoToDelete){
            consumoToDelete.delete(function(consumo){
				self.consumos.remove(consumo);
				self.consumos.valueHasMutated();
			});
        }


        function load(){
            var options = {
                idEvento : self.idEvento(),
                params : self.param(),
                callback : function(consumos){
                    self.consumos(consumos);
                }
            };
            Consumo.loadAll(options);
        }

        load();

    };
    
    function ConsumosForm(options,dataSet){
        var self = this;
        self.idEvento = ko.observable(options.idEvento);
        self.idParticipante = ko.observable(options.idParticipante);
        self.idConsumivel = ko.observable(options.idConsumivel);
        self.dataSet = ko.observable(dataSet);

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
            var options = {
                data : data,
                callback: function(consumo){
					self.dataSet().add(consumo);

				}
            };
            Consumo.new(options);

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
		self.consumosDataSet = ko.observable(new ConsumosDataSet(params));
        self.consumosForm = ko.observable(new ConsumosForm(params,self.consumosDataSet()));
        self.isParticipante = ko.observable(params.idParticipante);
        
        self.delete = function(consumo){
            self.consumosDataSet().remove(consumo);
        }

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