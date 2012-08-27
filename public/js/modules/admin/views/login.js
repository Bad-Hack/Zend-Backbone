define([ 'jquery', 'lodash', 'backbone', 'modules/admin/models/admin',
		'utils/tpl' ],

function($, _, Backbone, Admin, tpl) {

	var Login = Backbone.View.extend({
		tagName : "div",
		initialize : function() {
			$(this.el).unbind();
			$(this.el).bind("submit",'form',this.login);
		},

		render : function(eventName) {
			this.template = _.template(tpl.get('login'));
			if ($(this.el).length) {
				$(this.el).html(this.template(this.model.toJSON()));
			} else {
				$("body").append(this.template(this.model.toJSON()));
			}
			return this.el;
		},
		login: function(){
			var data = $(this).find("form").serialize();
			admin.login(data);
			return false;
		}
	});

	return Login;
});