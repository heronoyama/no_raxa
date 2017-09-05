define(['knockout',
	'components/EntidadeDashboard',
	'components/ParticipanteDataSet',
	'components/ConsumivelDataSet',
	'components/PainelRelatorio'],
		function(ko,EntidadeDashboard,ParticipanteDataSet,ConsumivelDataSet,PainelRelatorio){

	EntidadeDashboard.loadComponent();
	ParticipanteDataSet.loadComponent();
	ConsumivelDataSet.loadComponent();

	PainelRelatorio.loadComponent();

	ko.applyBindings();
	
	

});