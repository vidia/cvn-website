var async = require("async");
var models = require("../models");
var auth = require("../auth");
var logger = require("../logger");

module.exports = function(app)
{
    app.get("/attendance", auth.authenticate, function(req, res){
        models.event.findAll().then(function(events) {
            res.locals.events = events;
            res.render("attendances");
        });
    });

    app.param("eventid", function(req, res, next, eventid) {
        logger.info("Querying for event with id: " + eventid);
        models.event.findOne({ where: {uuid: eventid} } )
        .then(function(event) {
            if(!event) {
                res.sendStatus(404);
            } else {
                res.locals._event = event;
                next();
            }
        });
    });

    app.get("/attendance/:eventid", auth.authenticate, function(req, res) {
        models.attendance.findAll({
            where: {
                EventUuid : res.locals._event.uuid
            },
            include: [models.user, {
                model: models.attendanceType,
                where: {
                    $or: [{
                        name: "Confirmed"
                    }, {
                        name: "Requested"
                    }, {
                        name: "Cut"
                    }]
                }
            }]
        }).then(function(attendances) {
            res.locals.attendances = attendances;
            res.render("pull-attendance");
        });
    });

    app.post("/attendance/:eventId/pull", auth.authenticate, function(req, res) {

        models.attendance.findAll({
            where: {
                EventUuid: req.body.event
            },
            include: [
                {
                    model: models.attendanceType,
                    where: {
                        name: "Requested"
                    }
                }
            ]
        }).then(function(attendances) {
            res.send("Hi, nothing changed.");
        });
    });

    app.post("/attendance", auth.authenticate, function(req, res) {
        models.attendance.findOrCreate({
            where: {
                UserUuid : req.body.user,
                EventUuid: req.body.event
            }
        }).then(function(attendance, created) {
            attendance = attendance[0];
            attendance.AttendanceTypeUuid = req.body.type;
            if(attendance.changed("AttendanceTypeUuid")) {
                attendance.save()
                .then(function() {
                    logger.info("Saved or updated an attendance");
                    res.redirect("/dashboard");
                    return;
                });
            } else {
                res.redirect("/dashboard");
            }
        });
    });

    app.post("/attendance/confirm", auth.authenticate, function(req, res) {
        async.parallel({
            confirmedType: function(callback) {
                models.attendanceType.getConfirmedType(function(confirmedType) {
                    logger.info("Got the confirmed type" + confirmedType.uuid);
                    callback(null, confirmedType);
                });
            },
            cutType: function(callback) {
                models.attendanceType.getCutType(function(cutType) {
                    logger.info("Got the cut type" + cutType.uuid);
                    callback(null, cutType);
                });
            },
            updates: function(callback) {
                async.filter(req.body.users, function(useruuid, cb/*(isCut)*/) {
                    //Returns to cb(isCut) true if the uuid is cut, false if it is confirmed.
                    if(req.body.confirmed === undefined) {
                        logger.info("User " + useruuid + " isCut==" + true);
                        cb(true); //There are no confirmations, this is a cut
                    } else if(req.body.confirmed === useruuid) {
                        logger.info("User " + useruuid + " isCut==" + false);
                        cb(false); //The user is the only one confirmed, this is not a cut.
                    } else if(req.body.confirmed.indexOf(useruuid) > -1) {
                        logger.info("User " + useruuid + " isCut==" + false);
                        cb(false); //The user is confirmed, not a cut.
                    } else {
                        logger.info("User " + useruuid + " isCut==" + true);
                        cb(true); //It is not in the list, must be cut.
                    }
                }, function(cutusers) {
                    if(!req.body.confirmed) {
                        req.body.confirmed = [];
                    }
                    if(!cutusers) {
                        cutusers = [];
                    }
                    callback(null, {confirmed: req.body.confirmed, cut: cutusers});
                });
            }
        }, function(err, result) {
            async.parallel([
                function(callback) { //Update all the confirmed ushers.
                    models.attendance.update({
                        AttendanceTypeUuid : result.confirmedType.uuid
                    }, {
                       where: {
                            UserUuid : {
                                $in: result.updates.confirmed
                            },
                            EventUuid: req.body.event
                       }
                    }).then(function(affectedRows) {
                        callback(null);
                    });
                },
                function(callback) { //Update all the cut ushers.
                    models.attendance.update({
                        AttendanceTypeUuid : result.cutType.uuid
                    }, {
                       where: {
                            UserUuid : {
                                $in: result.updates.cut
                            },
                            EventUuid: req.body.event
                       }
                    }).then(function(affectedRows) {
                        callback(null);
                    });
                }
            ], function(err) {
                res.redirect("/attendance");
            });
        });
    });

    // -------------------------
    // | BEGIN Attendance Type |
    // -------------------------

    app.get("/attendance/type", auth.authenticate, function(req, res) {
        models.attendanceType.findAll().then(function(types) {
            res.render("attendanceTypes", {types: types});
        });
    });

    app.param("typeid", function(req, res, next, typeid) {
        models.attendanceType.findOne({where : {uuid: typeid}}).then(function(type) {
            if(type) {
                res.locals.type = type;
                next();
            } else {
                res.sendStatus(404);
            }
        });
    });

    app.get("/attendance/type/:typeid/archive", auth.authenticate, function(req, res) {
        res.locals.type.isEnabled = !res.locals.type.isEnabled;
        res.locals.type.save().then(function() {
            res.redirect("/attendance/type");
        });
    });

    app.post("/attendance/type/create", auth.authenticate, function(req, res) {
        var attendanceType = models.attendanceType.build({
            name: req.body.name,
            points: req.body.pointValue,
            isEnabled: true
        });
        attendanceType.save().then(function() {
            logger.info("Saved a new Attendance Type");
            res.redirect("/attendance/type");
        });
    });
};
