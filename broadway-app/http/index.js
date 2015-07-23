var express = require('express');
var path = require("path")
var bodyParser = require("body-parser"); 
var morgan = require('morgan')


module.exports = function setup(options, imports, register) {
    imports.logger.info("Loading http plugin"); 
    var app = this;

    var server = app.http = express();
    server.use(morgan("dev")); 
    server.set("views",  path.join(__dirname, '../view'))    
    server.set("view engine", "jade");
    server.use(bodyParser.urlencoded({
        extended: true
    }));
    server.use(bodyParser.json());
    //statics 
    server.use("/dist", express.static(path.join(__dirname, "public"))); 
    //TODO: Add error handling here.
    //Maybe add a component to look up error codes

    imports.auth.attach(server); 

    //routes/index.js runs a require against all routes
    require('./routes')(app, imports);

    server.listen(3000, function(err) {
    	imports.logger.info("Listening on port 3000"); 
    }); 
}

