ko.bindingHandlers.valueWithInit = {
    init: function(element, valueAccessor, allBindingsAccessor, data) {
        var property = valueAccessor(),
            value = element.value;

        //create the observable, if it doesn't exist 
        if (!ko.isWriteableObservable(data[property])) {
            data[property] = ko.observable();
        }

        data[property](value);

        ko.applyBindingsToNode(element, { value: data[property] });
    }
};