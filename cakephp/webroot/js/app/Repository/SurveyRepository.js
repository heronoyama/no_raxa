define(['knockout','gateway','models/Survey'],function(ko,Gateway,Survey){
    return function SurveyRepository(){
        var self = this;
        
        self.getSurvey = function(id,callback){
            var gatewayOptions = {
                idSurvey : 2, //parametrizar
                callback : function(surveyData){
                        var survey = new Survey(surveyData.survey);
                    callback(survey);
                }
            };

            Gateway.getSurvey(gatewayOptions);
        }
    }
});