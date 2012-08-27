define(
['jquery', 'lodash', 'backbone'],

function($, _, Backbone) {

    var admin = Backbone.Model.extend({
    	
    	// Default Variables
    	defaults : {
	    	isLoggedIn  : false,
	    	homePage : 'home',
	    	username 	: null,
	    	name		: null
    	},    	

        // Initialize the admin status currently
        initialize: function() {
        	this.loadAdminStatus();
        },
        
        loadAdminStatus: function(){
        	var self = this;
        	$.ajax({
        	    type: 'GET',
        	    url: window.baseUrl + '/admin/status/get',
        	    dataType: 'json',
        	    cache : false,
        	    async: false,
        	    success: function(data) {
        	    	self.set(data);
        	    },
        	    async: false
        	});
        },
        
        login: function(data){
        	var admin = window.admin;
        	var self = admin;
        	if(data == "undefined"){
        		data = $(this.el).find("form").serialize();
        	}
			$.ajax({
				type : "POST",
				url : window.baseUrl + "/admin/login",
				data : data,
				cache : false,
				async: false,
				success : function(result) {
					if (result.success) {
						self.set(result.data);
						$("#loginArea").html("");
						app.navigate("home", true);
					} else if (result.failure) {
						alert("Invalid Username and Password");
					}
				}
			});
			return false;
        	
        },
        
        logout: function(){
        	var admin = window.admin;
        	var self = admin;
			$.ajax({
				type : "DELETE",
				url : window.baseUrl + "/admin/login/delete",
				cache : false,
				success : function(result) {
					if (result.success) {
						self.set(result.data);
						app.navigate("login", true);
					} else if (result.failure) {
						alert("Unable to logout");
					}
				}
			});
			return false;
        }
    });
    return admin;
});