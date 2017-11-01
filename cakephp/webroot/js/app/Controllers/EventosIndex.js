define(['knockout','components/Survey'],	function(ko,Survey){

    function EventoIndex(){
        var self = this;
        self.survey = ko.observable();

        function initialize(){

            Survey.load(2, function(survey){
                self.survey(survey);
            });

            var a = document.querySelector('.naoPodeCriar > a');
            if(a)
                $(a).bind('click',self.showSurvey)
        }

        self.showSurvey = function(){
            self.survey().open();            
            return false;
        }

        initialize();


    }

    

    ko.applyBindings(new EventoIndex(), document.getElementById('eventoIndex'))

});