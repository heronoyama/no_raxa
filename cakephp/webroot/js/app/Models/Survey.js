define(['knockout','models/Pergunta'],function(ko,Pergunta){
    return function Survey(data){
        var self = this;
        self.nome = ko.observable(data.nome);
        self.id = ko.observable(data.id);
        
        var perguntas = data.perguntas.map(function(element) {
            return new Pergunta(element);
        });
        self.perguntas = ko.observableArray(perguntas);
    }
});