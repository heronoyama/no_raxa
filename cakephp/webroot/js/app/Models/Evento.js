define(['knockout', 'models/Participante', 'models/Consumivel'], 
 function(ko,Participante,Consumivel){

    function Evento(data){
        var self = this;
        self.id = ko.observable();
        self.localizacao = ko.observable();
        self.pessoasPrevistas = ko.observable();

        self.dataEvento = ko.observable();
        self.participantes = ko.observableArray([]);
        self.consumiveis = ko.observableArray([]);
        self.colaboracoes = ko.observableArray([]);
        self.pessoasPrevistasInt = ko.computed(
                function(){
                    return parseInt(self.pessoasPrevistas());
                });

        self.updateData = function(data){
            if(!data)
                return;
            if (data.id)
                self.id(data.id);
            if (data.participantes)
                self.participantes(data.participantes);
            if (data.consumiveis)
                self.consumiveis(data.consumiveis);
            if (data.colaboracoes)
                self.colaboracoes(data.colaboracoes);
        };

        self.addConsumivel = function(consumivelToAdd,callback){
            consumivelToAdd.save(self.id(),function(consumivel){
                var consumiveis = self.consumiveis();
                ko.utils.arrayPushAll(consumiveis,[consumivel]);
                self.consumiveis(consumiveis);
                self.consumiveis.valueHasMutated();
                callback();
            });
        };

        self.removeConsumivel = function(consumivelToRemove){
            consumivelToRemove.deletar(function(consumivel){
                self.consumiveis.remove(consumivel);
                self.consumiveis.valueHasMutated();
            });
        };

        self.load = function(options){
            $.getJSON('/api/eventos/' + self.id() + '.json',
                function(allData){
                    var evento = allData.evento;
                    self.localizacao(evento.localizacao);
                    self.pessoasPrevistas(evento.pessoas_previstas);
                    self.dataEvento(evento.data);
                    loadParticipantes(evento.participantes);
                    loadConsumiveis(options,evento.consumables);
                    options.callback(self);
            });
        };

        self.update = function(callback){
            //TODO acertar o uso de datas
            var data = {
                localizacao: self.localizacao(),
                pessoas_previstas: self.pessoasPrevistasInt()
            };
            $.ajax('/api/eventos/' + self.id() + '.json', {
                data : ko.toJSON(data),
                type : 'put',
                contentType: 'application/json',
                success: function(result) {
                    callback();
                },
                error: function(result) {
                    console.log(result);
                }
            });
        };

        function loadParticipantes(data){
                var participantes = $.map(data, function(item){
                    return new Participante(item);
                });
                self.participantes(participantes);
            };

        function loadConsumiveis(options, data){
            var model = options.consumivelModel? options.consumivelModel : Consumivel;
            var consumiveis = $.map(data, function(item){
                return new model(item);
            });
        self.consumiveis(consumiveis);
        };

        self.updateData(data);
    };
    
    return {
        load : function(id, callback){
            var evento = new Evento({id: id});
            evento.load(callback);
        },
        model : Evento
    };
});