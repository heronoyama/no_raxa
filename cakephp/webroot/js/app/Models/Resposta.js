define(['knockout','models/Pergunta'],function(ko,Pergunta){
    return function Resposta(data){
        var self = this;
        self.pergunta = ko.observable(new Pergunta(data.pergunta));
        self.id = ko.observable(data.id);
        self.resposta = ko.observable(data.resposta);

        self.parseResposta = ko.computed(function(){
            if(self.pergunta().tipoResposta() == 'Booleano')
                return self.resposta() == "1" ? true : false;
            return self.resposta();
        });

    }
});