define(['knockout',
	'components/ColaboracoesDataSet',
	'components/ConsumosDataSet'],
		function(ko,ColaboracoesDataSet,ConsumosDataSet){
	ColaboracoesDataSet.loadComponent();
	ConsumosDataSet.loadComponent();

	ko.applyBindings();

});