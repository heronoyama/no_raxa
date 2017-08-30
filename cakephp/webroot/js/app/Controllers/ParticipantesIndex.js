requirejs(['knockout','components/PathUtils','controllers/ParticipanteController'],
	function(ko,PathUtils,ParticipanteController){

	var idEvento = PathUtils.extractEventoId();
	ko.applyBindings(new ParticipanteController(idEvento),document.getElementById('ParticipantesModel'));
});