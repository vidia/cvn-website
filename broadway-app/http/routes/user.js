module.exports = function(app, imports)
{
    app.get("/login", function(req, res){
        res.render("login", {});
    });

    app.post('/login', function(req, res, next){
        imports.logger.info("Logging in a user"); 
        next(); 
    }, 
    imports.passport.authenticate('local', 
        { 
            successRedirect: '/dashboard',
            failureRedirect: '/login' 
        })
    );
    

    //SIGNUP 

    app.get("/signup", function(req, res){
    	res.render("register", {}); 
    })

    app.post("/signup", function(req, res) {
        if(req.body.password === req.body.confirmpassword) {
            imports.logger.info("Passwords match")
            var user = imports.user.build({
                email: req.body.email, 
                password: req.body.password,
                name: req.body.name
            })
            .save()
            .then(function(anotherTask) {
                imports.logger.info("User saved")
                res.redirect("../login")
            }).catch(function(error) {
                imports.logger.error("User failed to save", error)

            })
        } else {
            imports.logger.debug("Passwords did not match")
            res.render("register", {message: "Passwords do not match"}); 
        }
    });
};
