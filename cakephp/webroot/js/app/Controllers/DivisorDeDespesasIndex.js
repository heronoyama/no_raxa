define(['knockout','components/ParticipanteDataSet'],function(ko,ParticipanteDataSet){
	function DivisorDespesas(){
		var self = this;
	}

	ParticipanteDataSet.loadComponent();
	ko.applyBindings();
	
	// ko.applyBindings(new DivisorDespesas(),document.getElementById('DivisorDeDespesas'));

});