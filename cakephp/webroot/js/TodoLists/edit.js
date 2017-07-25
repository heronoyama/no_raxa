function toggleActivity(id){

	$.ajax('/api/activities/toggle_status/'+id+'.json',{
			type : 'put',
			contentType: 'application/json',
			success: function(result) { 
				alert('Atividade atualizada com sucesso!');
				var activity = $("#activity-"+id);
				if(activity.hasClass('concludedActivity'))
					activity.removeClass('concludedActivity');
				else
					activity.addClass('concludedActivity');

			},
			error: function(result) { console.log(result);}
		});
}

//TODO refatorar para usar knockout?