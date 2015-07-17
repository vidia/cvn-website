module.exports = function(app)
{
    app.http.get("/login", function(req, res){
        res.render("login", {});
    });

    app.http.get("/signup", function(req, res){
    	res.render("signup", {}); 
    })

    app.http.post('/login', passport.authenticate('local', { successRedirect: '/dashboard',
                                                    failureRedirect: '/login' }));
};
