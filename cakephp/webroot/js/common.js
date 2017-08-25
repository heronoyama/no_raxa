requirejs.config({
    baseUrl: '/js/vendor',
    paths: {
    	knockout: 'knockout-3.3.0',
    	text: 'requireText',
    	app: '../app',
    	models: '../app/Models',
    	controllers : '../app/Controllers',
        components:'../app/Components',
        templates:'../app/Templates',
        gateway:'../app/Gateway',
        repository: '../app/Repository'
    }
});