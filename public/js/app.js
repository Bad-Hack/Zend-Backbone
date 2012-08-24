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
			require(["modules/"+ window.module +"/models/"+url],
				function (adminView) {
				    alert("adminView");
			});
		},
		
		adminLogin : function() {
			alert("click here to login");
		},
		adminLogout : function() {
			/*var self = this;
			$.post(window.baseUrl + "/admin/rest/logout",  ,function(data){
				self.isLoggedIn = data.isLoggedIn == "undefined" ? "false" : data.isLoggedIn;
				app.navigate("/");
			});*/
		},
		
		adminHome : function (){
			if(this.isLoggedIn){
				alert("Welcome Home");
			}
			else{
				alert("Please Login To go to home");
				this.navigate("/login",true);
			}
		},
		
		// Check If The User is logged in as Admin
		before : function() {
			var self = this;
			$.get(window.baseUrl + "/admin/rest/check-login",function(data){
				self.isLoggedIn = data.isLoggedIn == "undefined" ? "false" : data.isLoggedIn;
			});
		}
	});

	window.app = new AppRouter();
	Backbone.history.start();

});
