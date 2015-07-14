module.exports = function(app)
{
    app.http.get("/login", function(req, res){
        res.render("login", {});
    });
};
