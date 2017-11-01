define(['knockout','repository/SurveyRepository','text!templates/Survey.html'],
    function(ko,SurveyRepository,htmlSurvey){
    function Survey(survey){
        var self = this;
        self.survey = ko.observable(survey);
        self.dialog = ko.observable();

        function initialize(){
            $('#survey').append(htmlSurvey);
                dialog = $("#surveyForm").dialog({
                    autoOpen: false,
                    height: 400,
                    width: 350,
                    modal: true,
                    buttons: {
                        'Enviar' : self.send,
                        Cancel: function() {
                            dialog.dialog( "close" );
                        }
                    },
                    close: function() { }
                });
                self.dialog(dialog);
            
        }

        self.send = function(){
            var respostas = {};
            respostas.Pergunta = {};
            self.survey().perguntas().forEach(function(pergunta) {
                var id = pergunta.id();
                var resposta = pergunta.resposta();
                respostas.Pergunta[id] = resposta;
            });
            new SurveyRepository().postResposta(self.survey().id(),respostas,function(result){
                alert("Obrigado por responder nosso questionário!");
                self.dialog().dialog('close');
            });
            
        }
        self.open = function(){
            self.dialog().dialog('open');
        }

        initialize();

    }

    return {
        load : function(idSurvey,callback){
            new SurveyRepository().getSurvey(idSurvey, function(survey){
                var surveyComponent = new Survey(survey);
                
                ko.applyBindings(surveyComponent,document.getElementById('surveyForm'));
                callback(surveyComponent);
            });

        }
    }
});