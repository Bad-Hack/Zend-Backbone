define([ 'jquery', 'lodash', 'backbone' ], function($, _, Backbone) {

	var tpl = {

		// Hash of preloaded templates for the app
		templates : {},

		// Recursively pre-load all the templates for the app.
		// This implementation should be changed in a production environment.
		// All the template files should be
		// concatenated in a single file.
		/*
		 * loadTemplates : function(names, callback) {
		 * 
		 * var that = this;
		 * 
		 * var loadTemplate = function(index) { var name = names[index];
		 * console.log('Loading template: ' + name); $.get('modules/' +
		 * window.module + '/templates/' + name + '.html', function(data) {
		 * that.templates[name] = data; index++; if (index < names.length) {
		 * loadTemplate(index); } else { callback(); } }); };
		 * 
		 * loadTemplate(0); },
		 */
		// Get template by name from hash of preloaded templates
		get : function(name) {
			var self = this;
			if (this.templates[window.module + "_" + name] == null
					|| this.templates[window.module + "_" + name] == "undefined") {
				$.ajax({
					type : "GET",
					url  : window.baseUrl + '/js/modules/' + window.module + '/templates/' + name + '.html',
					async : false,
					cache : false,
					success: function (data){
						self.templates[window.module + "_" + name] = data;
					}
				});
			}
			return this.templates[window.module + "_" + name];
		}
	};
	return tpl;
});