define(['knockout','models/Pergunta','models/Resposta'],function(ko,Pergunta,Resposta){
    return function Survey(data){
        var self = this;
        self.nome = ko.observable(data.nome);
        self.id = ko.observable(data.id);
        
        var allPerguntas = data.perguntas? data.perguntas : [];

        var perguntas = allPerguntas.map(function(element) {
            return new Pergunta(element);
        });
        self.perguntas = ko.observableArray(perguntas);

        var allRespostas = data.respostas? data.respostas : [];
        var respostas = allRespostas.map(function(element){
            return new Resposta(element);
        });

        self.respostas = ko.observableArray(respostas);
    }
});