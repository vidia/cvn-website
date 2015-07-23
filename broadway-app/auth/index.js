var passport = require("passport")
var passportLocalSequelize = require('passport-local-sequelize')
var session = require("express-session"); 

module.exports = function setup(options, imports, register) {
	passportLocalSequelize.attachToUser(imports.user, {
	    usernameField: 'email',
	    hashField: 'password',
	    saltField: 'passwordsalt'
	});

	passport.use(imports.user.createStrategy());
	passport.serializeUser(imports.user.serializeUser());
	passport.deserializeUser(imports.user.deserializeUser());
	
	register(null, {
		auth: {
			attach: function(app) {
				app.use(session({
					secret: "sdfgbsthnrtbtsdfhthaerhnrdsfhbtranet5",
					saveUninitialized: true,
                	resave: true
                }));
				app.use(passport.initialize())
				app.use(passport.session())
			}
		},
		passport: passport
	})

}