var async = require("async"); 

module.exports = function(app, imports)
{
    app.get("/dashboard", imports.auth.authenticate, function(req, res){
    	//TODO: Change this to a set of paallels and series functions so that the deps for variables are met. 
    	async.parallel([
    			function(callback) {
	    			imports.event.findAll().then(function(events) {
	    				res.locals.events = events; 
	    				callback(null); 
	    			})
    			},
    			function(callback) {

    				async.parallel([
						function(cb) {
							imports.attendanceType.findOrCreate({ 
				    			where: {
					    			name: "Requested"
					    		},
					    		defaults: {
					    			points: 0, 
					    			isEnabled: 1
					    		}
				    		}).then(function(requestType) {
				    			requestType = requestType[0]; 
				    			imports.logger.info("XXXXXXXXXXXXXXXXXXXXXCreated an attn Type : " + requestType); 
				    			res.locals.requestType = requestType; 
				    			cb(null); 
				    		});
						}, 
						function(cb) {
		    				imports.attendanceType.findOrCreate({ 
				    			where: {
					    			name: "Canceled"
					    		},
					    		defaults: {
					    			points: 0, 
					    			isEnabled: 1
					    		}
				    		}).then(function(cancelType, created) {
				    			res.locals.cancelType = cancelType[0];
				    			cb(null); 
				    		});
		    			}
					], function(err, results) {
						imports.attendance.findAll({
	    					where: {
	    						UserUuid: req.user.uuid, 
	    						AttendanceTypeUuid: res.locals.requestType.uuid
	    					}
	    				}).then(function(requested){
	    					async.map(requested, function(attendance, cb) {
	    						imports.event
	    						.findOne({where: { uuid: attendance.EventUuid }})
	    						.then(function(event) {
	    							cb(null, event); 
	    						})
	    					}, function(err, result) {
	    						res.locals.requested = result; 
	    						callback(null);
	    					})
	    				});
					});
    			}
    		], function(err) {
    			async.filter(res.locals.events, function(event, callback) {
    				imports.logger.info(event.name + " : " + res.locals.requested.indexOf(event));
    				callback(res.locals.requested.indexOf(event) < 0); 
    			}, function(result) {
    				res.locals.events = result; 
    				res.render("dashboard");    			
    			})
    		}
    	); 
    });
};
