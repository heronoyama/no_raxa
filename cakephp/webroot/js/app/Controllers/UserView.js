define(['knockout','controllers/SurveyController'],function(ko,SurveyController){

    ko.applyBindings(new SurveyController(),document.getElementById('SurveysModel'));
});