define(['knockout',
	'components/ParticipanteDataSet',
	'components/ConsumivelDataSet'],
		function(ko,ParticipanteDataSet,ConsumivelDataSet){
	
	function DivisorDespesas(){
		var self = this;
	}

	ParticipanteDataSet.loadComponent();
	ConsumivelDataSet.loadComponent();
	ko.applyBindings();
	
	// DivisorDespesas(),document.getElementById('DivisorDeDespesas'));

});