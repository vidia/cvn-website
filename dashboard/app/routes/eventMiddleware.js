var models = require("../models");
var auth = require("../auth");
var logger = require("../logger");

module.exports = {
    params: {
        "eventid":  function(req, res, next, eventid) {
            logger.info("Querying for event with id: " + eventid);
            models.event.findOne({ where: {uuid: eventid} } )
            .then(function(event) {
                if(!event) {
                    res.sendStatus(404);
                } else {
                    res._event = event; //TODO: Remove, compat.
                    res.locals._event = event;
                    next();
                }
            });
        }
    }, 
    routes: {
        "/events/create" : {
            "get": [
                auth.authenticate, 
                function(req, res) {
                    models.season.findAll().then(function(seasons) {
                        res.render("create-event", {seasons: seasons});
                    });
                }
            ], 
            "post": [
                auth.authenticate, 
                function(req, res, next){
                    if (!req.body.SeasonUuid) {
                        //Need to flash saying "please make a season"
                        res.redirect("../events/create");
                    }
                    //TODO: Check the inputs here!
                    models.event.build(req.body)
                    .save()
                    .then(function() {
                        logger.info("Event saved");
                        res.redirect("../events");
                    }).catch(function(err) {
                        logger.error("Event failed to save", err);
                        res.redirect("../events/create");
                    });
                }
            ]
        },
        "/events": {
            "get": [
                auth.authenticate, 
                function(req, res) {
                    models.event.findAll()
                    .then(function(events) {
                        res.render("events", {events: events});
                    });
                }
            ]
        }, 
        "/events/:eventid": {
            "get": [
                auth.authenticate, 
                    function(req, res) {
                    res.render("edit-event", { event : res._event });
                }
            ], 
            "post": [
                auth.authenticate, 
                function(req, res) {
                    for(var attr in req.body) {
                        if(req.body[attr]) {
                            res._event[attr] = req.body[attr];
                        }
                    }
                    res._event.save()
                    .then(function(event) {
                        res.render("edit-event", { event : event });
                    }).catch(function(err) {
                        logger.error("Event failed to save", err);
                    });
                }
            ]
        }, 
        "/events/:eventid/request": {
            "get": [
                auth.authenticate, 
                function(req, res) {
                    logger.info("In request function");
                    req.user.addAttendance(res._event);
                    req.user.save().then(function() {
                        logger.info("Saved user with attendance");
                        res.redirect("/dashboard");
                    });
                }
            ]
        }
    }//end routes
} //enc exports
