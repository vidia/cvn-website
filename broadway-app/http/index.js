var express = require('express');
var path = require("path")

module.exports = function setup(options, imports, register) {
    var app = this;

    var server = app.http = express();
    server.set("views",  path.join(__dirname, '../view'))    
    server.set("view engine", "jade");

    //statics 
    server.use("/dist", express.static(path.join(__dirname, "public"))); 
    //TODO: Add error handling here.
    //Maybe add a component to look up error codes


    //routes/index.js runs a require against all routes
    require('./routes')(app);

    server.listen(3000, function(err) {
    	console.log("Listening on port 3000"); 
    }); 
}

