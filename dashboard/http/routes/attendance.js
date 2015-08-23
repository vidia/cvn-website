var async = require("async"); 

module.exports = function(app, imports)
{
    app.get("/attendance", imports.auth.authenticate, function(req, res){
        imports.event.findAll().then(function(events) {
            var eventAttendances = {};

            async.each(events, function(event, callback) {
                imports.attendance.findAll({
                    where: {
                        EventUuid : event.uuid
                    }, 
                    include: [imports.user, {
                        model: imports.attendanceType, 
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
                    eventAttendances[event.uuid] = attendances; 
                    callback(); 
                })
            }, function(err) {
                res.render("pull-attendance", {events: events, attendances: eventAttendances})
            });
        });
    });

    app.post("/attendance", imports.auth.authenticate, function(req, res) {
        imports.attendance.findOrCreate({
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
                    imports.logger.info("Saved or updated an attendance")
                    res.redirect("/dashboard"); 
                    return; 
                })
            } else {
                res.redirect("/dashboard"); 
            }
        })
    }); 
    
    app.post("/attendance/confirm", imports.auth.authenticate, function(req, res) {
        async.parallel({
            confirmedType: function(callback) {
                imports.attendanceType.findOrCreate({ 
                    where: {
                        name: "Confirmed"
                    },
                    defaults: {
                        points: 0, 
                        isEnabled: 1, 
                        includeShow: 0
                    }
                }).then(function(confirmedType) {
                    confirmedType = confirmedType[0]; 
                    imports.logger.info("Got the confirmed type" + confirmedType.uuid)
                    callback(null, confirmedType); 
                });
            }, 
            cutType: function(callback) {
                imports.attendanceType.findOrCreate({ 
                    where: {
                        name: "Cut"
                    },
                    defaults: {
                        points: 20, 
                        isEnabled: 1, 
                        includeShow: 0
                    }
                }).then(function(confirmedType) {
                    confirmedType = confirmedType[0]; 
                    imports.logger.info("Got the confirmed type" + confirmedType.uuid)
                    callback(null, confirmedType); 
                });
            }, 
            updates: function(callback) {
                async.filter(req.body.users, function(useruuid, cb/*(isCut)*/) {
                    //Returns to cb(isCut) true if the uuid is cut, false if it is confirmed. 
                    if(req.body.confirmed === undefined) {
                        imports.logger.info("User " + useruuid + " isCut==" + true); 
                        cb(true); //There are no confirmations, this is a cut
                    } else if(req.body.confirmed == useruuid) {
                        imports.logger.info("User " + useruuid + " isCut==" + false); 
                        cb(false); //The user is the only one confirmed, this is not a cut. 
                    } else if(req.body.confirmed.indexOf(useruuid) > -1) {
                        imports.logger.info("User " + useruuid + " isCut==" + false); 
                        cb(false); //The user is confirmed, not a cut. 
                    } else {
                        imports.logger.info("User " + useruuid + " isCut==" + true); 
                        cb(true); //It is not in the list, must be cut. 
                    }
                }, function(cutusers) {
                    if(!req.body.confirmed) 
                        req.body.confirmed = []; 
                    if(!cutusers)
                        cutusers = []; 
                    callback(null, {confirmed: req.body.confirmed, cut: cutusers}); 
                })
            }
        }, function(err, result) {
            async.parallel([
                function(callback) { //Update all the confirmed ushers. 
                    imports.attendance.update({
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
                    imports.attendance.update({
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
            })
        })
    });

    // -------------------------
    // | BEGIN Attendance Type |
    // -------------------------

    app.get("/attendance/type", imports.auth.authenticate, function(req, res) {
        imports.attendanceType.findAll().then(function(types) {
            res.render("attendanceTypes", {types: types}); 
        });
    });

    app.param("typeid", function(req, res, next, typeid) {
        imports.attendanceType.findOne({where : {uuid: typeid}}).then(function(type) {
            if(type) {
                res.locals.type = type; 
                next(); 
            } else {
                res.sendStatus(404); 
            }
        })
    });

    app.get("/attendance/type/:typeid/archive", function(req, res) {
        res.locals.type.isEnabled = !res.locals.type.isEnabled; 
        res.locals.type.save().then(function() {
            res.redirect("/attendance/type"); 
        });
    });

    app.post("/attendance/type/create", imports.auth.authenticate, function(req, res) {
        var attendanceType = imports.attendanceType.build({
            name: req.body.name, 
            points: req.body.pointValue, 
            isEnabled: true
        })
        attendanceType.save().then(function() {
            imports.logger.info("Saved a new Attendance Type");
            res.redirect("/attendance/type"); 
        })
    });
};
