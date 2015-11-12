var passport = require("passport");
var LocalStrategy = require('passport-local');
var logger = require("../logger");
var models = require("../models");

logger.info("Loading passport plugin.");

// Serialize sessions
passport.serializeUser(function(user, done) {
	done(null, user.uuid);
});

passport.deserializeUser(function(uuid, done) {
	models.user.find({where: {uuid: uuid}})
	.then(function(user){
		if(!user) {
			logger.info("User was not found to match ID");
			done(null, false, { message: "User does not exist for id"});
		} else {
			logger.info("User was found to match ID");
			done(null, user);
		}
	});
});

// Use local strategy to create user account
passport.use(new LocalStrategy(
	function(email, password, done) {
		logger.info("Attempting to log in a user");
		models.user.find({ where: { email: email }})
		.then(function(user) {
			if (!user) {
				logger.info("User was not found for email");
				done(null, false, { message: 'Unknown user' });
			} else if (!user.checkPassword(password)) {
				logger.info("Password does not match");
				done(null, false, { message: 'Invalid password' });
			} else {
				logger.info("Login successful");
				done(null, user);
			}
		});
	}
	));

module.exports = {
	attach: function(app) {
		app.use(passport.initialize());
		app.use(passport.session());
	},
	authenticate: function(req, res, next) {
		// if user is authenticated in the session, carry on
		if (req.isAuthenticated()) {
			res.locals.currentuser = req.user;
			return next();
		}

	    // if they aren't redirect them to the home page
	    res.redirect('/login'); //TODO: add a param to redirect better to attempted page.
	},
	passport: passport
};