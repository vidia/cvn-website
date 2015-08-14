var async = require("async"); 

module.exports = function(app, imports)
{
    app.get("/attendance", function(req, res){
        imports.event.findAll().then(function(events) {
            var eventslist = [] + events; 

            //TODO: Use asyn
            var eventAttendances = {};

            async.each(events, function(event, callback) {
                imports.logger.info("ATTENDANCE OBJS: " + event.Attendances.length); 
                event.getAttendances().then(function(attendances) {
                    eventAttendances[event.uuid] = attendances; 
                    callback();
                })
            }, function(err) {
                res.render("pull-attendance", {events: events, attendances: eventAttendances})
            });
        });
    });
};
