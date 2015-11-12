var models = require("../models");
var auth = require("../auth");
var logger = require("../logger");

module.exports = function(app)
{
   app.get("/seasons", auth.authenticate, function(req, res) {
        models.season.findAll().then(function(seasons) {
            models.settings.getActiveSeasonId(function(seasonid) {
                logger.info("Got active season from settings store : " + seasonid);
                res.render("seasons", {seasons: seasons, activeSeason: seasonid});
            });
        });
    });

    app.param("seasonid", function(req, res, next, seasonid) {
        models.season.findOne({where : {uuid: seasonid}}).then(function(season) {
            if(season) {
                res.locals.season = season;
                next();
            } else {
                res.sendStatus(404);
            }
        });
    });

    app.post("/seasons/setActive", auth.authenticate, function(req, res) {
        models.season.findOne({ where: {uuid: req.body.season}}).then(function(season) {
            if(season) {
                logger.info("Setting the active season");
                models.settings.setActiveSeasonId(season.uuid, function() {
                    logger.info("Season set");
                    res.redirect("/seasons");
                });
            } else {
                res.sendStatus(404);
            }
        });
    });

    app.post("/seasons/create", auth.authenticate, function(req, res) {
        var season = models.season.build({
            name: req.body.name,
            startDate: req.body.startDate,
            endDate: req.body.endDate
        });
        season.save().then(function() {
            logger.info("Saved a new Season");
            res.redirect("/seasons");
        });
    });
};
