define(['knockout','repository/SurveyRepository'],function(ko,SurveyRepository){
    
    function SurveyController(){
        var self = this;
        self.repository = new SurveyRepository();
        self.respostasFeedback = ko.observableArray([]);

        function load(){
            self.repository.allAnswers(2, function(respostas){
                self.respostasFeedback(respostas);
            });

        }

        load();

    };

    return SurveyController;
});