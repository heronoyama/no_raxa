define(['knockout','gateway', 'models/Participante', 'models/Consumivel'], 
 function(ko,Gateway,Participante,Consumivel){

    function Evento(data){
        var self = this;
        self.id = ko.observable();
        self.localizacao = ko.observable();
        self.pessoasPrevistas = ko.observable();

        self.dataEvento = ko.observable();
        self.pessoasPrevistasInt = ko.computed(
                function(){
                    return parseInt(self.pessoasPrevistas());
                });

        self.updateData = function(data){
            if(!data)
                return;
            if (data.id)
                self.id(data.id);
        };

        self.load = function(options){
            Gateway.getEvento({
                idEvento: self.id(),
                callback : function(allData){
                    var evento = allData.evento;
                    self.localizacao(evento.localizacao);
                    self.pessoasPrevistas(evento.pessoas_previstas);
                    self.dataEvento(evento.data);
                    options.callback(self);
                }
            })

        };

        self.update = function(callback){
            
            var data = {
                localizacao: self.localizacao(),
                pessoas_previstas: self.pessoasPrevistasInt()
            };
            var gatewayOptions = {
                idEvento : self.id(),
                data : data,
                callback: callback
            }
            Gateway.updateEvento(gatewayOptions);
        };


        self.updateData(data);
    };
    
    return {
        load : function(id,options){
            var evento = new Evento({id: id});
            evento.load(options);
        },
        model : Evento
    };
});