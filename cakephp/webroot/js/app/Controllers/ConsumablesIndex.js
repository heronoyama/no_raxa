requirejs(['knockout','components/PathUtils','controllers/ConsumivelController'],function(ko,PathUtils,ConsumivelController){

var idEvento = PathUtils.extractEventoId();
ko.applyBindings(new ConsumivelController(idEvento),document.getElementById('ConsumablesModel'));

});
