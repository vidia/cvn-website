var async = require("async");

module.exports = function (app, imports) {
    app.get("/dashboard",
        imports.auth.authenticate,
        imports.attendanceType.getAllDefaultTypesMiddleware,
        function (req, res) {
            //TODO: Change this to a set of paallels and series functions so that the deps for variables are met.
            imports.logger.info("Created attendance types for dashboard.");
            async.parallel([
                function (callback) {
                    imports.attendance.findAll({
                        include: [
                            {
                                model: imports.event
                            },
                            {
                                model: imports.attendanceType,
                                where: {
                                    uuid: res.locals.cutType.uuid
                                }
                            }
                        ]
                    }).then(function (attendances) {
                        imports.logger.info("Got cut attendances");
                        res.locals.cutEvents = attendances;
                        callback(null);
                    });
                },
                function (callback) {
                    imports.attendance.findAll({
                        include: [
                            {
                                model: imports.event
                            },
                            {
                                model: imports.attendanceType,
                                where: {
                                    uuid: res.locals.requestType.uuid
                                }
                            }
                        ]
                    }).then(function (events) {
                        imports.logger.info("Got requested events");
                        res.locals.requestedEvents = events;
                        callback(null);
                    });
                },
                function (callback) {
                    imports.attendance.findAll({
                        include: [
                            {
                                model: imports.event
                            },
                            {
                                model: imports.attendanceType,
                                where: {
                                    uuid: res.locals.confirmedType.uuid
                                }
                            }
                        ]
                    }).then(function (events) {
                        imports.logger.info("Got confirmed events");
                        res.locals.confirmedEvents = events;
                        callback(null);
                    });
                }
            ], function () {

                imports.event.findAll({
                    where: {
                    }
                }).then(function (events) {

                    async.filter(events, function (event, callback) {
                        var i = 0;
                        for (i = 0; i < res.locals.cutEvents.length; i++) {
                            if (res.locals.cutEvents[i] && res.locals.cutEvents[i].Event) {
                                if (res.locals.cutEvents[i].Event.uuid === event.uuid) {
                                    callback(false);
                                    return;
                                }
                            }
                        }
                        for (i = 0; i < res.locals.requestedEvents.length; i++) {
                            if (res.locals.requestedEvents[i] && res.locals.requestedEvents[i].Event) {
                                if (res.locals.requestedEvents[i].Event.uuid === event.uuid) {
                                    callback(false);
                                    return;
                                }
                            }
                        }
                        for (i = 0; i < res.locals.confirmedEvents.length; i++) {
                            if (res.locals.confirmedEvents[i] && res.locals.confirmedEvents[i].Event) {
                                if (res.locals.confirmedEvents[i].Event.uuid === event.uuid) {
                                    callback(false);
                                    return;
                                }
                            }
                        }
                        callback(true);

                    }, function (results) {
                        imports.logger.info("Got available events");
                        res.locals.availableEvents = results;
                        imports.logger.info("Got events for types");
                        res.render("dashboard");
                    });
                });
            }); // end get events for types.
        }); //end .get()
};
