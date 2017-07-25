function ActivitiesViewModel() {
    this.firstName = "Bert";
    this.lastName = "Bertington";
}

ko.applyBindings(new ActivitiesViewModel(),document.getElementById('container'));
