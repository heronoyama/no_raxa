define(['knockout','models/Consumivel','gateway'],function(ko,Consumivel,Gateway){

    function ConsumivelRepository(idEvento,params){
        var self = this;
		self.idEvento = ko.observable(idEvento);
		self.params = params;
	    self.consumiveis = ko.observableArray([]);

	    self.nomeConsumivel =  ko.observable();

	    self.criaConsumivel = function(){
		    var novoConsumivel = new Consumivel.editModel({nome : self.nomeConsumivel(),idEvento:self.idEvento()});
		    novoConsumivel.save(function(consumivel){
    			var consumiveis = self.consumiveis();
		    	ko.utils.arrayPushAll(consumiveis,[consumivel]);
	    		self.consumiveis(consumiveis);
    			self.consumiveis.valueHasMutated();
			    self.nomeConsumivel(null);
		    })
	    };

	    self.delete = function(consumivelToDelete){
			var result = confirm("Deseja realmente deletar?");
			if(!result)
				return;
		    consumivelToDelete.delete(function(consumivel){
                    self.consumiveis.remove(consumivel);
                    self.consumiveis.valueHasMutated();
            });
    	};

	    function load(){
		    var options = {
    			idEvento : self.idEvento(),
			    model : Consumivel.editModel,
			    callback : function(consumiveis){
    				self.consumiveis(consumiveis);
			    },
			};
			if(self.params)
				options.params = 'include=('+self.params.join(',')+')';

		    Consumivel.loadAll(options);
	    }

	    load();
    }

    return {
		initialize: function(idEvento,params){
			return new ConsumivelRepository(idEvento,params);
		}
	}

});