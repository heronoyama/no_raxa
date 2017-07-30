function ActivityModel(id,isConcluded){
	var self = this;
	self.id = ko.observable(id);
	self.isConcluded = ko.observable(isConcluded);

	self.toggleStatus = function(){
		$.ajax('/api/activities/toggle_status/'+self.id()+'.json',{
			type : 'put',
			contentType: 'application/json',
			success: function(result) { 
				alert('Atividade atualizada com sucesso!');
				self.setupClass(self.isConcluded());
			},
			error: function(result) { console.log(result);}
		});
		return true;
	}

	self.setupClass = function(isConcluded){
		var activity = $('[data-id='+self.id()+']');
		if(isConcluded)
			activity.addClass('concludedActivity');
		else
			activity.removeClass('concludedActivity');
	}
	self.setupClass(isConcluded);
}

var activities = $(".activity");
activities.each(function(index){
	var activity = activities[index];
	var id = $(activity).data('id');
	var isConcluded = $(activity).data('isconcluded');
	ko.applyBindings(new ActivityModel(id,isConcluded),activity);
});
