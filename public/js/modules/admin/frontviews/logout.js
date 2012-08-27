define([ 'jquery', 'lodash', 'backbone', 'modules/admin/models/admin' ],

function($, _, Backbone, Admin) {
	var frontviewLogout = {
		render:function(){
			var admin = window.admin || new Admin();
			window.admin = admin;
			if (!admin.get('isLoggedIn')) {
				app.navigate("login", true);
			} else {
				admin.logout();
			}	
		}
	};
	return frontviewLogout;
});