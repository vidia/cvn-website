var passport = require("passport")
var LocalStrategy = require('passport-local')

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
	    	imports.logger.info("User was not found to match ID"); 
	    	done(null, false, { message: "User does not exist for id"}); 
	    } else {
	    	imports.logger.info("User was found to match ID"); 
	    	done(null, user);
		}
	  });
	});

	// Use local strategy to create user account
	passport.use(new LocalStrategy(
	  function(email, password, done) {
	  	imports.logger.info("Attempting to log in a user");
	    imports.user.find({ where: { email: email }})
	    .then(function(user) {
	      if (!user) {
	      	imports.logger.info("User was not found for email"); 
	        done(null, false, { message: 'Unknown user' });
	      } else if (!user.checkPassword(password)) {
	      	imports.logger.info("Password does not match"); 
	        done(null, false, { message: 'Invalid password' });
	      } else {
	      	imports.logger.info("Login successful");
	        done(null, user);
	      }
	    });
	  }
	));
	
	register(null, {
		auth: {
			attach: function(app) {
				app.use(passport.initialize())
				app.use(passport.session())
			}, 
			authenticate: function(req, res, next) {
				// if user is authenticated in the session, carry on 
			    if (req.isAuthenticated()) {
			    	res.locals.currentuser = req.user; 
			        return next();
			    }

			    // if they aren't redirect them to the home page
			    res.redirect('/login'); //TODO: add a param to redirect better to attempted page. 

			}
		},
		passport: passport
	})

}