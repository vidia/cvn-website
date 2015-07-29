var winston = require('winston');

module.exports = function setup(options, imports, register) {
	console.log("Preparing Winston...")
	var logger = new (winston.Logger)({
	    transports: [
	      new (winston.transports.Console)({
	      	'timestamp':true,
	      	'colorize': true,
	      })
	    ]
	});

	console.log("Winston Created")

	logger.info("Hello from Winston"); 

	register(null, {
		logger: logger
	}); 
}