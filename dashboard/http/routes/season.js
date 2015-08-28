module.exports = function(app, imports)
{
   app.get("/seasons", imports.auth.authenticate, function(req, res) {
        imports.season.findAll().then(function(seasons) {
            imports.settings.getActiveSeasonId(function(seasonid) {
                imports.logger.info("Got active season from settings store : " + seasonid); 
                res.render("seasons", {seasons: seasons, activeSeason: seasonid}); 
            })
        });
    });

    app.param("seasonid", function(req, res, next, seasonid) {
        imports.season.findOne({where : {uuid: seasonid}}).then(function(season) {
            if(season) {
                res.locals.season = season; 
                next(); 
            } else {
                res.sendStatus(404); 
            }
        })
    });

    app.post("/seasons/setActive", imports.auth.authenticate, function(req, res) {
        imports.season.findOne({ where: {uuid: req.body.season}}).then(function(season) {
            if(season) {
                imports.logger.info("Setting the active season"); 
                imports.settings.setActiveSeasonId(season.uuid, function() {
                    imports.logger.info("Season set"); 
                    res.redirect("/seasons"); 
                }); 
            } else {
                res.sendStatus(404); 
            }
        })
    });

    app.post("/seasons/create", imports.auth.authenticate, function(req, res) {
        var season = imports.season.build({
            name: req.body.name,
            startDate: req.body.startDate, 
            endDate: req.body.endDate
        })
        season.save().then(function() {
            imports.logger.info("Saved a new Season");
            res.redirect("/seasons"); 
        })
    });
};
