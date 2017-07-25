function ActivitiesIndexModel() {
    this.firstName = "Bert";
    this.lastName = "Bertington";
}

ko.applyBindings(new ActivitiesIndexModel(),document.getElementById('container'));
