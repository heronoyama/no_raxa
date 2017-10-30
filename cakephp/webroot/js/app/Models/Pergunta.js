define(['knockout'],function(ko){
    return function Pergunta(data){
        var self = this;
        self.pergunta = ko.observable(data.pergunta);
        self.id = ko.observable(data.id);
        self.tipoResposta = ko.observable(data.tipoResposta);


        self.getType = ko.computed(function(){
            if(self.tipoResposta() == 'Boooleano') //TODO arrumar
                return 'checkbox';
            return self.tipoResposta() == 'Numerico' ? 'number':'text';
        });

        self.key = ko.computed(function(){
            return "Question."+self.id();
        });

    }
});