var architect = require("architect");
var path = require("path");

var config = architect.loadConfig(path.join(__dirname, "/config/architect"));

architect.createApp(config, function (err, app) {
	if (err) {
		console.log("Error!", err);
		throw err; 
		return; 
	}
	console.log("Success"); 
});