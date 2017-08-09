define(['knockout'],function(ko){
	return function DataSet(idEvento){
		var self = this;

		self.idEvento = ko.observable(idEvento);
		self.dataSet = ko.observableArray([]);

		function load(){
			self.loadMethod().call(self,self.getLoadOptions());
			
			self.getElement().accordion({
				collapsible:true,
				header:'h4',
				heightStyle:'content',
				animate: 200,
				active:false});

		}

		self.getLoadOptions = function(){
			return {
				idEvento:self.idEvento(),
				callback: self.loadCallback
			}
		}

		self.getElement = function(){
			return $(self.element);
		};


		load();
	}
});