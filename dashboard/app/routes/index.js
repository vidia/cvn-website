var express = require('express');
var logger = require("../logger");

function applyMiddleware(routeDefinition) {
    var router = express.Router();
    logger.info("Adding new routes"); 
    
    for (var param in routeDefinition.params) {
        if (routeDefinition.params.hasOwnProperty(param)) {
            logger.info("Adding param " + param + " to route"); 
            router.param(param, routeDefinition.params[param]); 
        }
    }
    
    for (var path in routeDefinition.routes) {
        if (routeDefinition.routes.hasOwnProperty(path)) {
            logger.info("Adding routes for path: " + path); 
            var pathDef = routeDefinition.routes[path]; 
            for(var method in pathDef) {
                if(pathDef.hasOwnProperty(method)) {
                    logger.info("Adding: method=" + method + " middleware count: " + pathDef[method].length );
                    router[method](path, pathDef[method]);
                }
            }
        }
    }
    
    return router; 
}



module.exports = function(app) {

	if (!app) {
		throw new Error("No app given");
	}

	require("./user")(app);
	require("./dashboard")(app);
	// require("./event")(app);
	require("./attendance")(app);
	require("./season")(app);
    app.use(applyMiddleware(require("./eventMiddleware"))); 
    
}
