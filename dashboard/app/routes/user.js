var models = require("../models");
var auth = require("../auth");
var logger = require("../logger");

module.exports = function(app)
{

    //AUTH ----------------------------------------------------------
    app.get("/login", function(req, res){
        res.render("login", {});
    });

    app.post('/login', function(req, res, next){
        logger.info("Logging in a user");
        next();
    }, auth.passport.authenticate('local', {
        successRedirect: "/dashboard",
        failureRedirect: "/login"
    }));

    app.get("/signup", function(req, res){
    	res.render("register", {});
    });

    app.post("/signup", function(req, res) {
        if(req.body.password === req.body.confirmpassword) {
            logger.info("Passwords match");
            var user = models.user.build({
                email: req.body.email,
                password: req.body.password,
                name: req.body.name
            })
            .save()
            .then(function(anotherTask) {
                logger.info("User saved");
                res.redirect("../login");
            }).catch(function(error) {
                logger.error("User failed to save", error);
                res.redirect("/signup");
            });
        } else {
            logger.debug("Passwords did not match");
            res.render("register", {message: "Passwords do not match"});
        }
    });

    app.get("/logout", auth.authenticate, function(req, res) {
        req.logout();
        res.redirect("login");
    });
    //END AUTH ------------------------------------------------------------------------------

    app.param("userid", function(req, res, next, userid) {
        logger.info("Querying for user with id: " + userid);
        models.user.findOne({ where: {uuid: userid} } )
        .then(function(user) {
            if(!user) {
                res.sendStatus(404);
            } else {
                res.locals.user = user;
                next();
            }
        });
    });


    app.get("/users", auth.authenticate, function(req, res) {
        models.user.findAll().then(function(users) {
            res.render("users", {users: users});
        });
    });


    app.get("/users/new", auth.authenticate, function(req, res){
        res.render("create-user", {});
    });

    app.post("/users/new", auth.authenticate, function(req, res) {
        if(req.body.password === req.body.confirmpassword) {
            logger.info("Passwords match");
            var user = models.user.build({
                email: req.body.email,
                password: req.body.password,
                name: req.body.name
            })
            .save()
            .then(function(anotherTask) {
                logger.info("User saved");
                res.redirect("../users");
            }).catch(function(error) {
                logger.error("User failed to save", error);
                res.redirect("/users/new");
            });
        } else {
            logger.debug("Passwords did not match");
            //TODO: Change to flash with the session.
            res.render("create-user", {message: "Passwords do not match"});
        }
    });

    app.get("/users/:userid", auth.authenticate, function(req, res) {
        res.render("profile", {});
    });
    app.get("/profile", auth.authenticate, function(req, res) {
        res.render("profile", {user: res.locals.currentuser});
    });
    app.get("/profile/edit", auth.authenticate, function(req, res) {
        res.render("edit-user", {user: res.locals.currentuser});
    });
    app.get("/users/:userid/edit", auth.authenticate, function(req, res) {
        res.render("edit-user", {});
    });

    //TODO: Ugh not DRY. Make a middleware.
    app.post("/profile/edit", auth.authenticate, function(req, res) {
        for(var attr in req.body) {
            if(req.body[attr]) {
                res.locals.currentuser[attr] = req.body[attr];
            }
        }

        res.locals.currentuser.save()
        .then(function(user) {
            //Explicitly sending user here to overrite any data that was changed from before.
            res.redirect("profile");
        }).catch(function(err) {
            logger.error("user failed to save", err);
            res.redirect("/profile");
        });
    });

    app.post("/users/:userid/edit", auth.authenticate, function(req, res) {

        for(var attr in req.body) {
            if(req.body[attr]) {
                res.locals.user[attr] = req.body[attr];
            }
        }

        res.locals.user.save()
        .then(function(user) {
            //Explicitly sending user here to overrite any data that was changed from before.
            res.render("edit-user", { user : res.locals.user });
        }).catch(function(err) {
            logger.error("user failed to save", err);
            res.redirect("/users/"+user.locals.currentuser.uuid);
        });
    });

    app.get("/users/:userid/delete", auth.authenticate, function(req, res) {
        res.locals.user.destroy().then(function() {
            res.redirect("/users");
        });
    });
};
