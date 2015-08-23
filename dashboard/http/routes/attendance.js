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
                    include: [imports.user]
                }).then(function(attendances) {
                    eventAttendances[event.uuid] = attendances; 
                    callback(); 
                })
            }, function(err) {
                res.render("pull-attendance", {events: events, attendances: eventAttendances})
            });
        });
    });

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
};
