define(['knockout','repository/SurveyRepository','text!templates/Survey.html'],
    function(ko,SurveyRepository,htmlSurvey){
    function Survey(survey){
        var self = this;
        self.survey = ko.observable(survey);


    }

    return {
        load : function(idSurvey){
            new SurveyRepository().getSurvey(idSurvey, function(survey){
                var surveyComponent = new Survey(survey);
                $('#survey').append(htmlSurvey);
                var dialog = $("#surveyForm").dialog({
                    autoOpen: false,
                    height: 400,
                    width: 350,
                    modal: true,
                    buttons: {
                        Cancel: function() {
                            dialog.dialog( "close" );
                        }
                    },
                    close: function() { }
                });
                ko.applyBindings(surveyComponent,document.getElementById('survey'));
                dialog.dialog('open');
            });

        }
    }
});