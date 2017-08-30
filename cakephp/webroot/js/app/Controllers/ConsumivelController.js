define(['knockout','repository/ConsumivelRepository'],function(ko,ConsumivelRepository){

    function ConsumivelController(idEvento){
        var self = this;
        self.idEvento = ko.observable(idEvento);
        
        self.consumiveis = ko.observableArray([]);
	    self.nomeConsumivel =  ko.observable();
	    self.repository = ko.observable();

	    self.criaConsumivel = function(){
		    self.repository().novoConsumivelEdit(self.nomeConsumivel(),function(consumivel){
                var consumiveis = self.consumiveis();
                ko.utils.arrayPushAll(consumiveis,[consumivel]);
                self.consumiveis(consumiveis);
                self.consumiveis.valueHasMutated();
                self.nomeConsumivel(null);
    		});
	    };

        self.delete = function(consumivelToDelete){
            self.repository().delete(consumivelToDelete,function(consumivel){
                self.consumiveis.remove(consumivel);
                self.consumiveis.valueHasMutated();
            });
        };

        function load(){
            self.repository(new ConsumivelRepository(self.idEvento()));
            self.repository().all({
                editMode : true,
                callback: function(consumiveis){
                    self.consumiveis(consumiveis);
                }
            });
        }

	    load();

    }

    return ConsumivelController;

});