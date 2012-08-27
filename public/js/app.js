require([ 'jquery', 'lodash', 'backbone' ],

function($, _, Backbone) {

	var AppRouter = Backbone.Router.extend({
		
		initialize : function() {
			this.before();
		},

		routes : {
			"*url" : "handleRoutes"
		},
		
		handleRoutes : function(url){
			if(url == "" || url == null || url == "undefined")
				url = "login";
			
			require(["modules/"+ window.module +"/frontviews/"+url],function(viewObject){
				viewObject.render();
			});
			//$.getScript(window.baseUrl+"/js/modules/"+ window.module +"/frontviews/"+url+".js",function(data){eval(data);});
		},
		
		// Check If The User is logged in as Admin
		before : function() {
		}
	});

	window.app = new AppRouter();
	Backbone.history.start();

});
