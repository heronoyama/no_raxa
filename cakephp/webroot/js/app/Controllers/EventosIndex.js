define(['knockout','components/Survey','repository/SurveyRepository'],
	function(ko,Survey,SurveyRepository){

    function EventoIndex(){
        var self = this;
        self.survey = ko.observable();
        self.repository = new SurveyRepository();

        function initialize(){

            Survey.load(2, function(survey){
                self.survey(survey);
            });

            var a = document.querySelector('.naoPodeCriar > a');
            if(a)
                $(a).bind('click',self.showSurvey)
        }

        self.showSurvey = function(){
            self.repository.allAnswers(2, function(respostas){
                if(respostas.length <= 0)
                    self.survey().open();
                else {
                    $("#dialog-message").dialog({
                        modal: true,
                        buttons : {
                            OK : function(){
                                $(this).dialog('close');
                            }
                        }
                    });
                }

            });
            
            return false;
        }

        initialize();


    }

    

    ko.applyBindings(new EventoIndex(), document.getElementById('eventoIndex'))

});