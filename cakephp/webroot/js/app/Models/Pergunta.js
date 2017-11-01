define(['knockout'],function(ko){
    return function Pergunta(data){
        var self = this;
        self.pergunta = ko.observable(data.pergunta);
        self.id = ko.observable(data.id);
        self.tipoResposta = ko.observable(data.tipoResposta);

        self.getType = ko.computed(function(){
            if(self.tipoResposta() == 'Booleano') 
                return 'checkbox';
            return self.tipoResposta() == 'Numerico' ? 'number':'text';
        });

        self.key = ko.computed(function(){
            return "Question."+self.id();
        });
        self.getDefaultValue = function(){
            if(self.tipoResposta() == 'Booleano') 
                return false;
            return self.tipoResposta() == 'Numerico' ? 0:'';
        }
        self.resposta = ko.observable(self.getDefaultValue());

        self.getAttr = ko.computed(function(){
            var attr = {
                type: self.getType(),
                name: self.key()};
            return attr;
        });

    }
});