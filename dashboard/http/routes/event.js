module.exports = function(app, imports)
{

    app.get("/events/create", imports.auth.authenticate, function(req, res){
        imports.season.findAll().then(function(seasons) {
            res.render("create-event", {seasons: seasons});

        })
    });

    app.post('/events/create', imports.auth.authenticate, function(req, res, next){
        if (!req.body.SeasonUuid) {
            //Need to flash saying "please make a season"
            res.redirect("../events/create")
        }

        imports.event.build(req.body)
        .save()
        .then(function() {
            imports.logger.info("Event saved"); 
            res.redirect("../events"); 
        }).catch(function(err) {
            imports.logger.error("Event failed to save", err); 
            res.redirect("../events/create")
        })
    });

    app.get("/events", imports.auth.authenticate, function(req, res) {
        imports.event.findAll()
        .then(function(events) {
            res.render("events", {events: events})
        })
    })

    app.param("eventid", function(req, res, next, eventid) {
        imports.logger.info("Querying for event with id: " + eventid)
        imports.event.findOne({ where: {uuid: eventid} } )
        .then(function(event) {
            if(!event) {
                res.sendStatus(404); 
            } else {
                res._event = event; //TODO: Remove, compat. 
                res.locals._event = event; 
                next(); 
            }
        })
    });

    app.get("/events/:eventid", imports.auth.authenticate, function(req, res) {
        res.render("edit-event", { event : res._event }); 
    })

    app.post("/events/:eventid", imports.auth.authenticate, function(req, res) {

        for(var attr in req.body) {
            if(req.body[attr])
                res._event[attr] = req.body[attr];
        }

        res._event.save()
        .then(function(event) {
            res.render("edit-event", { event : event }); 
        }).catch(function(err) {
            imports.logger.error("Event failed to save", err); 
        })
    })


    //Actions on an event.
    app.get("/events/:eventid/request", imports.auth.authenticate, function(req, res) {
        imports.logger.info("In request function"); 
        req.user.addAttendance(res._event);
        req.user.save().then(function() {
            imports.logger.info("Saved user with attendance"); 
            res.redirect("/dashboard"); 
        })
    });
};
