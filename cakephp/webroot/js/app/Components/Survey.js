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
                        Cancel: function() {
                            dialog.dialog( "close" );
                        }
                    },
                    close: function() { }
                });
                self.dialog(dialog);
                self.dialog().dialog('open');
            
        }

        initialize();

    }

    return {
        load : function(idSurvey){
            new SurveyRepository().getSurvey(idSurvey, function(survey){
                var surveyComponent = new Survey(survey);
                
                ko.applyBindings(surveyComponent,document.getElementById('surveyForm'));
                
            });

        }
    }
});