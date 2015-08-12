module.exports = function(app, imports)
{
    app.get("/dashboard", imports.auth.authenticate, function(req, res){
    	imports.event.findAll()
    	.then(function(events) {
    		req.user.getAttendances().then(function(attendances){
    			imports.logger.info(attendances[0]); 
    			res.render("dashboard", {events: events, requested: attendances});    			
    		}); 
    	})
    });
};
