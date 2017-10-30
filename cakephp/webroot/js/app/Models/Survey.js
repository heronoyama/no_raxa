define(['knockout','models/Pergunta'],function(ko,Pergunta){
    return function Survey(data){
        var self = this;
        self.nome = ko.observable(data.nome);
        
        var perguntas = data.perguntas.map(function(element) {
            return new Pergunta(element);
        });
        self.pergutnas = ko.observableArray(perguntas);
    }
});