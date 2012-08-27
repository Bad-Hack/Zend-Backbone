define([ 'jquery', 'lodash', 'backbone', 'modules/admin/models/admin' ],

function($, _, Backbone, Admin) {
	var frontviewLogin = {
			render: function(){
				window.admin = window.admin || new Admin();
				if (admin.get('isLoggedIn')) {
					app.navigate("home", true);
				} else {
					require(["modules/admin/views/login"],function(LoginView){
						var loginView = new LoginView({
							model : admin,
							el:$("#loginArea")
						});
						loginView.render();
					});
				}
			}
	};
	return frontviewLogin;
});