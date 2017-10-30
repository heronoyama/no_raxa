define(['knockout'],function(ko){
    return function Pergunta(data){
        var self = this;
        self.pergunta = ko.observable(data.pergunta);
        self.id = ko.observable(data.id);
        self.tipoResposta = ko.observable(data.tipoResposta);
    }
});