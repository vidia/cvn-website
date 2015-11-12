var winston = require('winston');

console.log('Preparing Winston...');
var logger = new winston.Logger({
    transports: [
        new winston.transports.Console({
            timestamp: true,
            colorize: true
        })
    ]
});

console.log("Winston Created");

logger.info("Hello from Winston");

module.exports = logger;