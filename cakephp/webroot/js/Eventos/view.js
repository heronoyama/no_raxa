function EventoModel(){
	var self=this;
	self.id = ko.observable();
	self.nome = ko.observable();
        self.localizacao = ko.observable();
        self.pessoasPrevistas = ko.observable();
        self.dataEvento = ko.observable();
        
        this.editing = ko.observable(false);
	
        //TODO dirtyFlag
	this.edit = function() { this.editing(true); };
        
        this.save = function() {
            var data = ko.toJSON({
                localizacao: self.localizacao(),
                pessoas_previstas: parseInt(self.pessoasPrevistas())
            });
            //TODO acertar o uso de datas
            
            $.ajax('/api/eventos/'+self.id()+'.json',
			{
			data : ko.toJSON(data),
			type : 'put',
			contentType: 'application/json',
			success: function(result) { 
                                console.log(result);
				alert("Evento atualizado com sucesso!");
                                self.editing(false);
			},
			error: function(result) { 
				console.log(result);
			}
		});
        };


};

ko.applyBindings(new EventoModel(),document.getElementById("EventoModel"));
