define(['knockout','gateway','models/Survey'],function(ko,Gateway,Survey){
    return function SurveyRepository(){
        var self = this;
        
        self.getSurvey = function(id,callback){
            var gatewayOptions = {
                idSurvey : id,
                callback : function(surveyData){
                        var survey = new Survey(surveyData.survey);
                    callback(survey);
                }
            };

            Gateway.getSurvey(gatewayOptions);
        }

        self.postResposta = function(id,data,callback){
            var gatewayOptions = {
                idSurvey : id,
                callback : callback,
                data : ko.toJSON(data)
            };

            Gateway.postAnswer(gatewayOptions);

        }
    }
});