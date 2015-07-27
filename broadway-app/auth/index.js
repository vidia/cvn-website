var passport = require("passport")
var LocalStrategy = require('passport-local')
var session = require("express-session"); 

module.exports = function setup(options, imports, register) {
	imports.logger.info("Loading auth plugin.")


	// Serialize sessions
	passport.serializeUser(function(user, done) {
	  done(null, user.uuid);
	});

	passport.deserializeUser(function(uuid, done) {
	  imports.user.find({where: {uuid: uuid}})
	  .then(function(user){
	    if(!user) {
	    	done(null, false, { message: "User does not exist for id"}); 
	    } else {
	    	done(null, user);
		}
	  });
	});

	// Use local strategy to create user account
	passport.use(new LocalStrategy(
	  function(email, password, done) {
	    imports.user.find({ where: { email: email }})
	    .then(function(user) {
	      if (!user) {
	        done(null, false, { message: 'Unknown user' });
	      } else if (!user.checkPassword(password)) {
	        done(null, false, { message: 'Invalid password' });
	      } else {
	        done(null, user);
	      }
	    });
	  }
	));
	
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